<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieGenreRequest;
use App\Models\MovieGenre;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class MovieGenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = MovieGenre::query();

            return DataTables::of($query->get())
                ->addColumn('action', function ($item) {
                    return '<form class="inline-block" action="' . route('dashboard.genre.destroy', $item->id) . '" method="POST">
                    <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        Hapus
                    </button>
                        ' . method_field('delete') . csrf_field() . '
                </form>';
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.genre.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieGenreRequest $request)
    {
        $data = $request->all();
        MovieGenre::create($data);

        return redirect()->route('dashboard.genre.index');
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
    public function destroy(MovieGenre $genre)
    {
        $genre->delete();

        return redirect()->route('dashboard.genre.index');
    }
}
