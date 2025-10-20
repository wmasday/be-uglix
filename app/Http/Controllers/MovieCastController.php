<?php

namespace App\Http\Controllers;

use App\Models\MovieCast;
use Illuminate\Http\Request;

class MovieCastController extends Controller
{
    public function index()
    {
        return response()->json(MovieCast::paginate(50));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'actor_id' => 'required|exists:actors,id',
            'role_name' => 'nullable|string|max:150',
        ]);
        $cast = MovieCast::create($data);
        return response()->json($cast, 201);
    }

    public function show($movie_id, $actor_id)
    {
        $cast = MovieCast::where('movie_id', $movie_id)->where('actor_id', $actor_id)->firstOrFail();
        return response()->json($cast);
    }

    public function update(Request $request, $movie_id, $actor_id)
    {
        $cast = MovieCast::where('movie_id', $movie_id)->where('actor_id', $actor_id)->firstOrFail();
        $data = $request->validate([
            'role_name' => 'nullable|string|max:150',
        ]);
        $cast->update($data);
        return response()->json($cast);
    }

    public function destroy($movie_id, $actor_id)
    {
        MovieCast::where('movie_id', $movie_id)->where('actor_id', $actor_id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}


