<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function index()
    {
        return response()->json(Actor::paginate(50));
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
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'photo_url' => 'nullable|url|max:255',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
        $photoUrl = $this->storePhoto($request);
        if ($photoUrl) {
            $data['photo_url'] = $photoUrl;
        }
        $actor = Actor::create($data);
        return response()->json($actor, 201);
    }

    public function show(Actor $actor)
    {
        return response()->json($actor);
    }

    public function movies(Actor $actor)
    {
        $movies = $actor->movies()->with(['genre', 'episodes'])->paginate(20);
        return response()->json($movies);
    }

    public function update(Request $request, Actor $actor)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:150',
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'photo_url' => 'nullable|url|max:255',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
        $photoUrl = $this->storePhoto($request);
        if ($photoUrl) {
            $data['photo_url'] = $photoUrl;
        }
        $actor->update($data);
        return response()->json($actor);
    }

    public function destroy(Actor $actor)
    {
        $actor->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
