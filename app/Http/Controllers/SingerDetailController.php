<?php

namespace App\Http\Controllers;

use App\Http\Requests\MusicRequest;
use App\Models\Music;
use App\Models\Singer;
use DateTime;
use Illuminate\Http\Request;
use wapmorgan\Mp3Info\Mp3Info;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SingerDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Singer $singer)
    {
        $count = Music::with(['singer'])->where('singers_id', $singer->id)->count();
        if (request()->ajax()) {
            $query = Music::with(['singer'])->where('singers_id', $singer->id);
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
                ->editColumn('duration', function ($item) {
                    $minute = floor($item->duration / 60);
                    $second = $item->duration % 60;

                    return "$minute:$second";
                })
                ->editColumn('url_poster', function ($item) {
                    return '<img style="width: 100px; height: 100px; object-fit: cover;" src="' . url($item->url_poster) . '"/>';
                })
                ->rawColumns(['action', 'url_poster'])
                ->make();
        }

        return view('pages.dashboard.detail-singer.index', compact('singer', 'count'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Singer $singer)
    {
        return view('pages.dashboard.detail-singer.create', compact('singer'));
    }

    /**
     * ADD MUSIC IN DETAIL PAGE
     */
    public function store(MusicRequest $request)
    {
        $singer = Singer::where('id', $request->singers_id)->first();
        $audio = new Mp3Info($request->file('music'));

        $pathPoster = $request->file('poster')->store("public/music");
        $pathPosterForDatabase = str_replace('public', 'storage', $pathPoster);
        $pathMusic = $request->file('music')->store("public/music");
        $pathMusicForDatabase = str_replace('public', 'storage', $pathMusic);


        // dd($audio->duration);

        Music::create([
            'title' => $request->title,
            'singers_id' => $request->singers_id,
            'duration' => $audio->duration,
            'url_poster' => $pathPosterForDatabase,
            'url_music' => $pathMusicForDatabase,
        ]);

        return redirect()->route('dashboard.singer.detail.index', $request->singers_id);
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
        return redirect()->route('dashboard.singer.detail.index');
    }
}
