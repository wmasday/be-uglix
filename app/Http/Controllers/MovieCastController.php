<?php

namespace App\Http\Controllers;

use App\Models\MovieCast;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class MovieCastController extends Controller
{
    public function index(Request $request)
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
        $search = $request->get('search', '');
        $movieId = $request->get('movie_id', '');
        $actorId = $request->get('actor_id', '');

        $query = MovieCast::with(['movie', 'actor']);

        // Only show casts for published movies for guests
        if (!$user) {
            $query->whereHas('movie', function($q) {
                $q->where('is_published', true);
            });
        }

        // Search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->whereHas('movie', function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                })->orWhereHas('actor', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })->orWhere('role_name', 'LIKE', "%{$search}%");
            });
        }

        // Movie filter
        if (!empty($movieId)) {
            $query->where('movie_id', $movieId);
        }

        // Actor filter
        if (!empty($actorId)) {
            $query->where('actor_id', $actorId);
        }

        $casts = $query->orderBy('movie_id', 'desc')->orderBy('actor_id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($casts);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'actor_id' => 'required|exists:actors,id',
            'role_name' => 'nullable|string|max:150',
        ]);
        $cast = MovieCast::create($data);
        $cast->load(['movie', 'actor']);
        return response()->json($cast, 201);
    }

    public function show($movie_id, $actor_id, Request $request)
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

        $cast = MovieCast::with(['movie', 'actor'])
            ->where('movie_id', $movie_id)
            ->where('actor_id', $actor_id)
            ->firstOrFail();

        // Only show casts for published movies for guests
        if (!$user && (!$cast->movie || !$cast->movie->is_published)) {
            abort(404, 'Cast not found');
        }

        return response()->json($cast);
    }

    public function update(Request $request, $movie_id, $actor_id)
    {
        $cast = MovieCast::where('movie_id', $movie_id)->where('actor_id', $actor_id)->firstOrFail();
        $data = $request->validate([
            'movie_id' => 'sometimes|required|exists:movies,id',
            'actor_id' => 'sometimes|required|exists:actors,id',
            'role_name' => 'nullable|string|max:150',
        ]);
        $cast->update($data);
        $cast->load(['movie', 'actor']);
        return response()->json($cast);
    }

    public function destroy($movie_id, $actor_id)
    {
        MovieCast::where('movie_id', $movie_id)->where('actor_id', $actor_id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
