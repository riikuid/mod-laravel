<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\MovieGenre;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class MovieGenreController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->id;
        $name = $request->input('name');
        $genres = MovieGenre::get();

        if ($genres->isEmpty()) {
            return ResponseFormatter::error(
                null,
                'Data genre tidak ada',
            );
        }

        if ($id) {
            $genre = MovieGenre::with([('movies')])->find($id);
            if ($genre) {
                return ResponseFormatter::success(
                    $genre,
                    'Data genre berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'id genre tidak ada',
                );
            }
        }

        if ($name) {
            $genre = MovieGenre::with([('movies')])->where('name', 'like', '%' . $name . '%')->get();
            if ($genre) {
                return ResponseFormatter::success(
                    $genre,
                    'Data genre berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data genre tidak ada',
                );
            }
        }

        return ResponseFormatter::success(
            $genres,
            'Data genre berhasil diambil'
        );
    }
}
