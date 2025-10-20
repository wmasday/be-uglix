<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DropdownController extends Controller
{
    /**
     * Get all unique years from movies for dropdown
     */
    public function getYears(): JsonResponse
    {
        $years = Movie::select('release_year')
            ->whereNotNull('release_year')
            ->distinct()
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
    public function getCountries(): JsonResponse
    {
        $countries = Movie::select('country')
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->distinct()
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
