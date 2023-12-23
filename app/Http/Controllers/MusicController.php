<?php

namespace App\Http\Controllers;

use App\Http\Requests\MusicRequest;
use App\Models\Music;
use App\Models\Singer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use wapmorgan\Mp3Info\Mp3Info;
use Yajra\DataTables\Facades\DataTables;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Music::with('singer');
        if (request()->ajax()) {
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                <form class="inline-block" action="' . route('dashboard.music.destroy', $item->id) . '" method="POST">
                <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                    Hapus
                </button>
                    ' . method_field('delete') . csrf_field() . '
                </form>';
                })
                ->editColumn('url_poster', function ($item) {
                    return '<img style="width: 70px; height: 70px; object-fit: cover;" src="' . url($item->url_poster) . '"/>';
                })
                ->editColumn('duration', function ($item) {
                    $minute = floor($item->duration / 60);
                    $second = $item->duration % 60;

                    return "$minute:$second";
                })
                ->rawColumns(['action', 'url_poster'])
                ->make();
        }
        return view('pages.dashboard.music.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MusicRequest $request)
    {
        $singer = Singer::where('id', $request->singers_id)->first();

        $pathPoster = $request->file('poster')->store("public/music");
        $pathPosterForDatabase = str_replace('public', 'storage', $pathPoster);
        $pathMusic = $request->file('music')->store("public/music");
        $pathMusicForDatabase = str_replace('public', 'storage', $pathMusic);

        $audio = new Mp3Info($request->file('music'));
        // dd($audio->duration);

        Music::create([
            'title' => $request->title,
            'singers_id' => $request->singers_id,
            'duration' => $audio->duration,
            'url_poster' => $pathPosterForDatabase,
            'url_music' => $pathMusicForDatabase,
        ]);

        return redirect()->route('dashboard.music.index');
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
    public function destroy(Music $music)
    {
        $music->delete();
        return redirect()->route('dashboard.music.index');
    }
}
