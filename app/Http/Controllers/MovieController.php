<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use App\Models\MovieGenre;
use App\Models\MovieItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Movie::with('genre');

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="inline-block border border-blue-500 bg-blue-500 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-800 focus:outline-none focus:shadow-outline"
                    href="' . route('dashboard.movie.show', $item->id) . '">
                    Detail
                    </a>
                    <form class="inline-block" action="' . route('dashboard.movie.destroy', $item->id) . '" method="POST">
                    <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                    Hapus
                    </button>
                    ' . method_field('delete') . csrf_field() . '
                    </form>';
                })
                ->editColumn('url_poster', function ($item) {
                    return '<img style="max-width: 150px;" src="' . url($item->url_poster) . '"/>';
                })
                ->editColumn('duration', function ($item) {
                    return '' . $item->duration . ' menit';
                })
                ->rawColumns(['action', 'url_poster'])
                ->make();
        }

        return view('pages.dashboard.movie.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = MovieGenre::all();
        return view('pages.dashboard.movie.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request)
    {
        $path = $request->file('files')->store('public/movie/cover');
        $pathForDatabase = str_replace('public', 'storage', $path);

        Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'genres_id' => $request->genres_id,
            'release_year' => $request->release_year,
            'url_poster' => $pathForDatabase,
        ]);

        return redirect()->route('dashboard.movie.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        $item = MovieItem::where('movies_id', $movie->id)->first();

        if (request()->ajax()) {
            $query = MovieItem::where('movies_id', $movie->id);
            // dd($query);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="inline-block border border-indigo-500 bg-indigo-500 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-800 focus:outline-none focus:shadow-outline"
                    href="' . url($item->url) . '">
                    Open Video
                    </a>
                    <form class="inline-block" action="' . route('dashboard.item.destroy', $item->id) . '" method="POST">
                    <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        Hapus
                    </button>
                        ' . method_field('delete') . csrf_field() . '
                    </form>';
                })
                ->editColumn('thumbnail', function ($item) {
                    return '<img width="320" height="240"><source src="' . url($item->thumbnail) . '"></img>';
                })
                ->editColumn('duration', function ($item) {
                    return '' . $item->duration . ' menit';
                })
                ->rawColumns(['action', 'thumbnail'])
                ->make();
        }

        return view('pages.dashboard.movie.show', compact('movie', 'item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        $genres = MovieGenre::orderBy('name', 'asc')->get();
        return view('pages.dashboard.movie.edit', compact('movie', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, Movie $movie)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/movie/cover');

            $movie->update([
                'title' => $movie->title,
                'description' => $movie->description,
                'genres_id' => $movie->genres_id,
                'release_year' => $movie->release_year,
                'url_poster' => $path,
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'genres_id' => 'required|integer',
                'release_year' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $movie->update([
                'title' => $request->title,
                'description' => $request->description,
                'genres_id' => $request->genres_id,
                'release_year' => $request->release_year,
                'url_poster' => $movie->url_poster,
            ]);
        }

        return redirect()->route('dashboard.movie.show', $movie->id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('dashboard.movie.index');
    }
}
