<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Music;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->id;
        $name = $request->input('name');
        $musics = Music::with([('singer')])->get();

        if ($musics->isEmpty()) {
            return ResponseFormatter::error(
                null,
                'Data musik tidak ada',
            );
        }

        if ($id) {
            $music = Music::with([('musics')])->find($id);
            if ($music) {
                return ResponseFormatter::success(
                    $music,
                    'Data Music berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'id Music tidak ada',
                );
            }
        }

        if ($name) {
            $music = Music::with([('musics')])->where('name', 'like', '%' . $name . '%')->get();
            if ($music) {
                return ResponseFormatter::success(
                    $music,
                    'Data Music berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Music tidak ada',
                );
            }
        }

        return ResponseFormatter::success(
            $musics,
            'Data genre berhasil diambil'
        );
    }
}
