<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function index()
    {
        return response()->json(Episode::paginate(50));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'season_number' => 'required|integer',
            'episode_number' => 'required|integer',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'duration_sec' => 'nullable|integer',
            'sources_url' => 'required|url|max:255',
            'thumbnail_url' => 'nullable|url|max:255',
            'release_date' => 'nullable|date',
        ]);
        $episode = Episode::create($data);
        return response()->json($episode, 201);
    }

    public function show(Episode $episode)
    {
        return response()->json($episode);
    }

    public function update(Request $request, Episode $episode)
    {
        $data = $request->validate([
            'season_number' => 'sometimes|required|integer',
            'episode_number' => 'sometimes|required|integer',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'duration_sec' => 'nullable|integer',
            'sources_url' => 'sometimes|required|url|max:255',
            'thumbnail_url' => 'nullable|url|max:255',
            'release_date' => 'nullable|date',
        ]);
        $episode->update($data);
        return response()->json($episode);
    }

    public function destroy(Episode $episode)
    {
        $episode->delete();
        return response()->json(['message' => 'Deleted']);
    }
}


