<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        
        $query = Genre::query();

        // Search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Order by id since timestamps are disabled, and include movies count
        $genres = $query->withCount('movies')->orderBy('id', 'desc')->get();
        
        return response()->json($genres);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:genres,name',
            'description' => 'nullable|string|max:300',
        ]);
        $genre = Genre::create($data);
        return response()->json($genre, 201);
    }

    public function show(Genre $genre)
    {
        $genre->loadCount('movies');
        return response()->json($genre);
    }

    public function update(Request $request, Genre $genre)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:100|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string|max:300',
        ]);
        $genre->update($data);
        return response()->json($genre);
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json(['message' => 'Deleted']);
    }
}


