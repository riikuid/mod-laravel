<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function getAll(Request $request)
    {
        $id = $request->id;
        $title = $request->title;
        $tahun_rilis = $request->tahun_rilis;
        $genre = $request->genre;
        $movies = Movie::with(['genre', 'items'])->get();

        if ($movies->isEmpty()) {
            return ResponseFormatter::error(
                null,
                'Data movie tidak ada'
            );
        }

        $movie = Movie::with(['genre', 'items']);

        if ($id) {
            $target = $movie->find($id);
            if ($target) {
                return ResponseFormatter::success(
                    $target,
                    'Data movie berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data movie tidak ada'
                );
            }
        }

        if ($title) {
            $query = $movie->where('title', 'like', '%' . $title . '%');
            $target = $query->get();
            if ($target) {
                if ($target->isEmpty()) {
                    return ResponseFormatter::success(
                        null,
                        'Data movie like title = ' . $title . ' tidak ada '
                    );
                }
                return ResponseFormatter::success(
                    $target,
                    'Movie like title =' . $title . ' berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data movie tidak ada'
                );
            }
        }

        if ($tahun_rilis) {
            $target = $movie->where('release_year', $tahun_rilis)->get();
            if ($target) {
                if ($target->isEmpty()) {
                    return ResponseFormatter::success(
                        null,
                        'Data movie tahun ' . $tahun_rilis . ' tidak ada '
                    );
                }
                return ResponseFormatter::success(
                    $target,
                    'Data movie tahun ' . $tahun_rilis . ' berhasil diambil'
                );
            }
        }

        if ($genre) {
            $target = $movie->whereHas('genre', function ($movie) use ($genre) {
                $movie->where('name', $genre);
            })->get();
            if ($target) {
                if ($target->isEmpty()) {
                    return ResponseFormatter::success(
                        null,
                        'Tidak ada movie dengan genre ' . $genre . ''
                    );
                }
                return ResponseFormatter::success(
                    $target,
                    'Data movie ber-genre ' . $genre . ' berhasil diambil'
                );
            }
        }

        return ResponseFormatter::success(
            $movies,
            'Data movie berhasil diambil'
        );
    }
}
