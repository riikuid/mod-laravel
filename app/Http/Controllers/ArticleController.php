<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Article::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="inline-block border border-blue-500 bg-blue-500 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-800 focus:outline-none focus:shadow-outline"
                    href="' . route('dashboard.article.edit', $item->id) . '">
                    Edit
                    </a>
                    <form class="inline-block" action="' . route('dashboard.article.destroy', $item->id) . '" method="POST">
                    <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                    Hapus
                    </button>
                    ' . method_field('delete') . csrf_field() . '
                    </form>';
                })
                ->editColumn('description', function ($item) {
                    $itemDescription = $item->description;
                    $words = explode(" ", $itemDescription); // Pecah teks menjadi array kata

                    if (count($words) > 100) {
                        $shortDescription = implode(" ", array_slice($words, 0, 100));
                    } else {
                        // Jika ada 100 kata atau kurang, gunakan seluruh teks
                        $shortDescription = $itemDescription;
                    }
                    return $shortDescription;
                })
                ->editColumn('thumbnail', function ($item) {
                    return '<img style="max-width: 150px;" src="' . url($item->thumbnail) . '"/>';
                })
                ->rawColumns(['action', 'thumbnail', 'description'])
                ->make();
        }

        return view('pages.dashboard.article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $path = $request->file('file')->store('public/article');
        $pathForDatabase = str_replace('public', 'storage', $path);

        Article::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $pathForDatabase,
        ]);

        return redirect()->route('dashboard.article.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('pages.dashboard.article.edit', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('pages.dashboard.article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/article');

            $article->update([
                'title' => $article->title,
                'description' => $article->description,
                'thumbnail' => $path,
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $article->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('dashboard.article.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('dashboard.article.index');
    }
}
