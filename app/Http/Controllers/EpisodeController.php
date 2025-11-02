<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class EpisodeController extends Controller
{
    // File upload helper for episode thumbnail
    protected function storeThumbnail($request) {
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $path = $request->file('thumbnail')->store('episodes', 'public');
            return $request->getSchemeAndHttpHost() . '/storage/' . $path;
        }
        return null;
    }

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

        $query = Episode::with(['movie']);

        // Only show episodes for published movies for guests
        if (!$user) {
            $query->whereHas('movie', function($q) {
                $q->where('is_published', true);
            });
        }

        // Search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Movie filter
        if (!empty($movieId)) {
            $query->where('movie_id', $movieId);
        }

        return response()->json($query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page));
    }

    public function store(Request $request)
    {
        $rules = [
            'movie_id' => 'required|exists:movies,id',
            'season_number' => 'nullable|integer',
            'episode_number' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_sec' => 'nullable|integer',
            'sources_url' => 'required|string|max:255',
            'thumbnail_url' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'release_date' => 'nullable|date',
        ];

        // For FormData, validate differently
        if ($request->hasFile('thumbnail')) {
            $rules['thumbnail_url'] = 'nullable|string|max:255';
        } else {
            $rules['thumbnail_url'] = 'nullable|url|max:255';
        }

        $data = $request->validate($rules);

        // Handle file upload
        $thumbnailUrl = $this->storeThumbnail($request);
        if ($thumbnailUrl) {
            $data['thumbnail_url'] = $thumbnailUrl;
        }

        // Remove file from data array if it exists
        unset($data['thumbnail']);

        // Set default season_number if not provided
        if (!isset($data['season_number'])) {
            $data['season_number'] = 1;
        }

        $episode = Episode::create($data);
        $episode->load(['movie']);
        return response()->json($episode, 201);
    }

    public function show(Episode $episode, Request $request)
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

        // Load movie relationship to check published status
        $episode->load('movie');

        // Only show episodes for published movies for guests
        if (!$user && (!$episode->movie || !$episode->movie->is_published)) {
            abort(404, 'Episode not found');
        }

        return response()->json($episode);
    }

    public function update(Request $request, Episode $episode)
    {
        $rules = [
            'movie_id' => 'sometimes|required|exists:movies,id',
            'season_number' => 'nullable|integer',
            'episode_number' => 'sometimes|required|integer',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'duration_sec' => 'nullable|integer',
            'sources_url' => 'sometimes|required|string|max:255',
            'thumbnail_url' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
            'release_date' => 'nullable|date',
        ];

        // For FormData, validate differently
        if ($request->hasFile('thumbnail')) {
            $rules['thumbnail_url'] = 'nullable|string|max:255';
        } else {
            $rules['thumbnail_url'] = 'nullable|url|max:255';
        }

        $data = $request->validate($rules);

        // Handle file upload
        $thumbnailUrl = $this->storeThumbnail($request);
        if ($thumbnailUrl) {
            $data['thumbnail_url'] = $thumbnailUrl;
        }

        // Remove file from data array if it exists
        unset($data['thumbnail']);

        $episode->update($data);
        $episode->load(['movie']);
        return response()->json($episode);
    }

    public function destroy(Episode $episode)
    {
        $episode->delete();
        return response()->json(['message' => 'Deleted']);
    }
}


