<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class ActorController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);
        $search = $request->get('search', '');

        $query = Actor::query();

        // Search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('bio', 'LIKE', "%{$search}%");
            });
        }

        $actors = $query->withCount('movies')->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
        
        return response()->json($actors);
    }

    // File upload helper for actor photo
    protected function storePhoto($request) {
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $path = $request->file('photo')->store('actors', 'public');
            return $request->getSchemeAndHttpHost() . '/storage/' . $path;
        }
        return null;
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:150',
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'photo_url' => 'nullable|string|max:255',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ];

        // For FormData, validate differently
        if ($request->hasFile('photo')) {
            $rules['photo_url'] = 'nullable|string|max:255';
        } else {
            $rules['photo_url'] = 'nullable|url|max:255';
        }

        $data = $request->validate($rules);

        $photoUrl = $this->storePhoto($request);
        if ($photoUrl) {
            $data['photo_url'] = $photoUrl;
        }

        // Remove file from data array if it exists
        unset($data['photo']);

        $actor = Actor::create($data);
        return response()->json($actor, 201);
    }

    public function show(Actor $actor)
    {
        $actor->loadCount('movies');
        return response()->json($actor);
    }

    public function movies(Actor $actor, Request $request)
    {
        // Check if user is authenticated (even without middleware)
        $user = null;
        if ($request->bearerToken()) {
            try {
                $token = PersonalAccessToken::findToken($request->bearerToken());
                if ($token) {
                    $user = $token->tokenable;
                }
            } catch (\Exception $e) {
                // Token invalid, treat as guest
            }
        }

        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);

        $query = $actor->movies()->with(['genre', 'episodes']);

        // Only show published movies for guests
        if (!$user) {
            $query->where('is_published', true);
        }

        $movies = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
        return response()->json($movies);
    }

    public function update(Request $request, Actor $actor)
    {
        $rules = [
            'name' => 'sometimes|required|string|max:150',
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'photo_url' => 'nullable|string|max:255',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ];

        // For FormData, validate differently
        if ($request->hasFile('photo')) {
            $rules['photo_url'] = 'nullable|string|max:255';
        } else {
            $rules['photo_url'] = 'nullable|url|max:255';
        }

        $data = $request->validate($rules);

        $photoUrl = $this->storePhoto($request);
        if ($photoUrl) {
            $data['photo_url'] = $photoUrl;
        }

        // Remove file from data array if it exists
        unset($data['photo']);

        $actor->update($data);
        return response()->json($actor);
    }

    public function destroy(Actor $actor)
    {
        $actor->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
