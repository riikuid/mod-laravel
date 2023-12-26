<?php

namespace App\Http\Controllers;

use App\Http\Requests\SingerRequest;
use App\Models\Music;
use App\Models\Singer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SingerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Singer::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="inline-block border border-blue-500 bg-blue-500 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-800 hover:border-blue-800 focus:outline-none focus:shadow-outline"
                    href="' . route('dashboard.singer.detail.index', $item->id) . '">
                    Detail
                    </a>
                    <button onclick="Delete(' . $item->id . ')" id="' . $item->id . '" class="bg-red-500 text-white rounded-md px-2 py-1 m-2 ml-4">
                                Hapus
                            </button>
                            ';
                    //         <form class="inline-block" action="' . route('dashboard.singer.destroy', $item->id) . '" method="POST">
                    //     <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                    //         Hapus
                    //     </button>
                    //         ' . method_field('delete') . csrf_field() . '
                    // </form>
                })
                ->editColumn('url_profile', function ($item) {
                    return '<img style="width: 70px; height: 70px; object-fit: cover;" src="' . url($item->url_profile) . '"/>';
                })
                ->editColumn('music_count', function ($item) {
                    $count = Music::with(['singer'])->where('singers_id', $item->id)->count();
                    return  $count . ' musik';
                })
                ->rawColumns(['action', 'url_profile'])
                ->make();
        }

        return view('pages.dashboard.singer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.singer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SingerRequest $request)
    {
        $path = $request->file('file')->store("public/music");
        $pathForDatabase = str_replace('public', 'storage', $path);

        Singer::create([
            'name' => $request->name,
            'url_profile' => $pathForDatabase,
        ]);

        return redirect()->route('dashboard.singer.index');
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
    public function update(Request $request, Singer $singer)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/music');
            $pathForDatabase = str_replace('public', 'storage', $path);

            $singer->update([
                'name' => $singer->name,
                'url_profile' => $pathForDatabase,
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $singer->update([
                'name' => $request->name,
                'url_profile' => $singer->url_profile,
            ]);
        }

        return redirect()->route('dashboard.singer.detail.index', $singer->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Singer $singer)
    {
        $singer->delete();
        $singer->musics()->delete();
        // $musics = Music::where('singers_id', $singer->id);

        return redirect()->route('dashboard.singer.index');
    }
}
