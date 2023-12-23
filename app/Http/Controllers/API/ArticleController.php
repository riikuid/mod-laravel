<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->id;
        $title = $request->title;
        $articles = Article::orderBy('id', 'desc')->get();

        if ($articles->isEmpty()) {
            return ResponseFormatter::error(
                null,
                'Data article tidak ada'
            );
        }

        if ($id) {
            $target = $articles->find($id);
            if ($target) {
                return ResponseFormatter::success(
                    $target,
                    'Data article berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data article tidak ada'
                );
            }
        }

        if ($title) {
            $target = $articles->where('title', 'like', '%' . $title . '%')->get();
            if ($target) {
                if ($target->isEmpty()) {
                    return ResponseFormatter::success(
                        null,
                        'Data article like title = ' . $title . ' tidak ada '
                    );
                }
                return ResponseFormatter::success(
                    $target,
                    'article like title =' . $title . ' berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data article tidak ada'
                );
            }
        }


        return ResponseFormatter::success(
            $articles,
            'Data article berhasil diambil'
        );
    }
}
