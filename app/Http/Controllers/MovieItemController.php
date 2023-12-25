<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieItemRequest;
use App\Models\Movie;
use App\Models\MovieItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MovieItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Movie $movie)
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Movie $movie)
    {
        return view('pages.dashboard.detail-movie.create', compact('movie'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieItemRequest $request, Movie $movie)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $pathMovie = $file->store('public/movie');
            $pathMovieForDatabase = str_replace('public', 'storage', $pathMovie);

            $pathThumbnail = $request->file('thumbnail')->store('public/movie');
            $pathThumbnailForDatabase = str_replace('public', 'storage', $pathThumbnail);

            MovieItem::create([
                'movies_id' => $movie->id,
                'title' => $request->title,
                'thumbnail' => $pathThumbnailForDatabase,
                'duration' => $request->duration,
                'url' => $pathMovieForDatabase,
            ]);
        }

        return redirect()->route('dashboard.movie.show', $movie->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MovieItem $item)
    {
        $item->delete();
        return redirect()->route('dashboard.movie.show', $item->movies_id);
    }
}
