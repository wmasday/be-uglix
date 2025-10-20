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

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'photo_url' => 'nullable|url|max:255',
        ]);
        $actor = Actor::create($data);
        return response()->json($actor, 201);
    }

    public function show(Actor $actor)
    {
        return response()->json($actor);
    }

    public function update(Request $request, Actor $actor)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:150',
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'photo_url' => 'nullable|url|max:255',
        ]);
        $actor->update($data);
        return response()->json($actor);
    }

    public function destroy(Actor $actor)
    {
        $actor->delete();
        return response()->json(['message' => 'Deleted']);
    }
}


