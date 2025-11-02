<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class MovieController extends Controller
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
        $genreId = $request->get('genre_id', '');
        
        $query = Movie::with(['genre', 'episodes', 'actors']);

        // Only show published for guests
        if (!$user) {
            $query->where('is_published', true);
        } else {
            // For admin: Allow status filter, but show all if no filter is provided
            $status = $request->get('status');
            if (!empty($status) && $status !== '') {
                if ($status === 'published') {
                    $query->where('is_published', true);
                } elseif ($status === 'draft') {
                    $query->where('is_published', false);
                }
            }
            // If status is empty or not provided, show all movies (both published and unpublished)
        }

        // Search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Genre filter
        if (!empty($genreId)) {
            $query->where('genre_id', $genreId);
        }

        $results = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
        
        return response()->json($results);
    }

    // File upload for poster (new method)
    protected function storePoster($request) {
        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            $path = $request->file('poster')->store('posters', 'public');
            return $request->getSchemeAndHttpHost() . '/storage/' . $path;
        }
        return null;
    }

    public function store(Request $request)
    {
        // Handle both JSON and FormData
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster_url' => 'nullable|string|max:255',
            'poster' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'sources_url' => 'required|string|max:255',
            'release_year' => 'nullable|integer',
            'type' => 'required|string|in:Movie,Series|max:10',
            'genre_id' => 'nullable|exists:genres,id',
            'duration_sec' => 'nullable|integer',
            'rating' => 'nullable|numeric|min:0|max:5',
            'country' => 'nullable|string|max:100',
            'is_published' => 'nullable|boolean',
        ];

        // For FormData, validate differently
        if ($request->hasFile('poster')) {
            $rules['poster_url'] = 'nullable|string|max:255';
        } else {
            $rules['poster_url'] = 'nullable|url|max:255';
        }

        $data = $request->validate($rules);

        // Prefer uploaded file over URL
        $posterFileUrl = $this->storePoster($request);
        if ($posterFileUrl) {
            $data['poster_url'] = $posterFileUrl;
        }

        // Remove file from data array if it exists
        unset($data['poster']);

        // Handle boolean conversion from FormData (FormData sends strings)
        if (isset($data['is_published'])) {
            $data['is_published'] = filter_var($data['is_published'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
        } else {
            $data['is_published'] = false;
        }

        // Remove empty poster_url if not set
        if (empty($data['poster_url'])) {
            unset($data['poster_url']);
        }

        $data['created_by'] = $request->user()->id;

        $movie = Movie::create($data);
        $movie->load(['genre', 'episodes', 'actors']);
        return response()->json($movie, 201);
    }

    public function show(Movie $movie, Request $request)
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

        // Only show published movies for guests
        if (!$user && !$movie->is_published) {
            abort(404, 'Movie not found');
        }

        return response()->json($movie->load(['genre', 'episodes', 'actors']));
    }

    public function update(Request $request, Movie $movie)
    {
        $rules = [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'poster_url' => 'nullable|string|max:255',
            'poster' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'sources_url' => 'sometimes|required|string|max:255',
            'release_year' => 'nullable|integer',
            'type' => 'sometimes|required|string|in:Movie,Series|max:10',
            'genre_id' => 'nullable|exists:genres,id',
            'duration_sec' => 'nullable|integer',
            'rating' => 'nullable|numeric|min:0|max:5',
            'country' => 'nullable|string|max:100',
            'is_published' => 'nullable|boolean',
        ];

        // For FormData, validate differently
        if ($request->hasFile('poster')) {
            $rules['poster_url'] = 'nullable|string|max:255';
        } else {
            $rules['poster_url'] = 'nullable|url|max:255';
        }

        $data = $request->validate($rules);

        // Prefer uploaded file over URL
        $posterFileUrl = $this->storePoster($request);
        if ($posterFileUrl) {
            $data['poster_url'] = $posterFileUrl;
        }

        // Remove file from data array if it exists
        unset($data['poster']);

        // Handle boolean conversion from FormData (FormData sends strings)
        if (isset($data['is_published'])) {
            $data['is_published'] = filter_var($data['is_published'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $movie->is_published;
        }

        // Remove empty poster_url if not set and no file uploaded
        if (empty($data['poster_url']) && !$posterFileUrl) {
            unset($data['poster_url']);
        }

        $movie->update($data);
        $movie->load(['genre', 'episodes', 'actors']);
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
