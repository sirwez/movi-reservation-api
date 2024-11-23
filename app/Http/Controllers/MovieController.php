<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index() {
        $movie = Movie::with('showTimes')->get();
        return response()->json($movie, 200);
    }
    public function create(Request $request) {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'genre' => 'required',
            'duration' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = Storage::disk('public')->put('images', $request->file('image'));

        $movie = Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'genre' => $request->genre,
            'duration' => $request->duration,
        ]);
        return response()->json($movie, 201);
    }

    public function list() {
        $movies = Movie::all();
        return response()->json($movies, 200);
    }

    public function showById($id) {
        $movie = Movie::find($id);
        if($movie == null) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        return response()->json($movie, 200);
    }

    public function showByName(Request $request) {
        $movie = Movie::where('title', 'like', '%' . $request->title . '%')->get();
        if($movie == null) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        return response()->json($movie, 200);
    }

    public function showByGenre(Request $request) {
        $movie = Movie::where('genre', 'like', '%' . $request->genre . '%')->get();
        if($movie == null) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        return response()->json($movie, 200);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'genre' => 'required',
            'duration' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $movie = Movie::find($id);
        
        if($request->hasFile('image')) {
            Storage::disk('public')->delete($movie->image);
            $path = Storage::disk('public')->put('images', $request->file('image'));
            $movie->image = $path;
        }

        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->genre = $request->genre;
        $movie->duration = $request->duration;
        $movie->save();
        $movie = Movie::find($id);

        return response()->json($movie, 200);
    }

    public function delete($id) {
        $movie = Movie::find($id);
        if($movie == null) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        Storage::disk('public')->delete($movie->image);
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully'], 200);
    }
}
