<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        return response()->json(
            Movie::with(['genre', 'episodes', 'actors'])->paginate(20)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster_url' => 'nullable|url|max:255',
            'sources_url' => 'required|url|max:255',
            'release_year' => 'nullable|integer',
            'type' => 'required|string|in:Movie,Series|max:10',
            'genre_id' => 'nullable|exists:genres,id',
            'duration_sec' => 'nullable|integer',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_published' => 'boolean',
        ]);

        $data['created_by'] = $request->user()->id;

        $movie = Movie::create($data);
        return response()->json($movie, 201);
    }

    public function show(Movie $movie)
    {
        return response()->json($movie->load(['genre', 'episodes', 'actors']));
    }

    public function update(Request $request, Movie $movie)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'poster_url' => 'nullable|url|max:255',
            'sources_url' => 'sometimes|required|url|max:255',
            'release_year' => 'nullable|integer',
            'type' => 'sometimes|required|string|in:Movie,Series|max:10',
            'genre_id' => 'nullable|exists:genres,id',
            'duration_sec' => 'nullable|integer',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_published' => 'boolean',
        ]);

        $movie->update($data);
        return response()->json($movie);
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(['message' => 'Deleted']);
    }
}


