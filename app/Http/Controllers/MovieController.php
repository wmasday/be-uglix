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

    public function newReleases(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);

        $movies = Movie::with(['genre', 'episodes', 'actors'])
            ->where('is_published', true)
            ->where('release_year', '>=', now()->year - 2) // Last 2 years
            ->orderBy('release_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($movies);
    }

    public function topRated(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);
        
        $movies = Movie::with(['genre', 'episodes', 'actors'])
            ->where('is_published', true)
            ->whereNotNull('rating')
            ->where('rating', '>', 0)
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($movies);
    }

    public function search(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $genreId = $request->get('genre_id', '');
        $country = $request->get('country', '');
        $year = $request->get('year', '');
        $type = $request->get('type', '');

        $query = Movie::with(['genre', 'episodes', 'actors'])
            ->where('is_published', true);

        // Search in title and description
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filter by genre
        if (!empty($genreId)) {
            $query->where('genre_id', $genreId);
        }

        // Filter by country
        if (!empty($country)) {
            $query->where('country', $country);
        }

        // Filter by year
        if (!empty($year)) {
            $query->where('release_year', $year);
        }

        // Filter by type (Movie/Series)
        if (!empty($type)) {
            $query->where('type', $type);
        }

        $movies = $query->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($movies);
    }
}
