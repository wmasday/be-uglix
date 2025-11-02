<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Laravel\Sanctum\PersonalAccessToken;

class DropdownController extends Controller
{
    /**
     * Get all unique years from movies for dropdown
     */
    public function getYears(Request $request): JsonResponse
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

        $query = Movie::select('release_year')
            ->whereNotNull('release_year');

        // Only show years from published movies for guests
        if (!$user) {
            $query->where('is_published', true);
        }

        $years = $query->distinct()
            ->orderBy('release_year', 'desc')
            ->pluck('release_year')
            ->filter()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $years
        ]);
    }

    /**
     * Get all genres for dropdown
     */
    public function getGenres(): JsonResponse
    {
        $genres = Genre::select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $genres
        ]);
    }

    /**
     * Get all unique countries from movies for dropdown
     */
    public function getCountries(Request $request): JsonResponse
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

        $query = Movie::select('country')
            ->whereNotNull('country')
            ->where('country', '!=', '');

        // Only show countries from published movies for guests
        if (!$user) {
            $query->where('is_published', true);
        }

        $countries = $query->distinct()
            ->orderBy('country')
            ->pluck('country')
            ->filter()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $countries
        ]);
    }
}
