<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Singer;
use Illuminate\Http\Request;

class SingerController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->id;
        $name = $request->input('name');
        $singers = Singer::with([('musics')])->get();

        if ($singers->isEmpty()) {
            return ResponseFormatter::error(
                null,
                'Data singer tidak ada',
            );
        }

        if ($id) {
            $singer = Singer::with([('musics')])->find($id);
            if ($singer) {
                return ResponseFormatter::success(
                    $singer,
                    'Data singer berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'id singer tidak ada',
                );
            }
        }

        if ($name) {
            $singer = Singer::with([('musics')])->where('name', 'like', '%' . $name . '%')->get();
            if ($singer) {
                return ResponseFormatter::success(
                    $singer,
                    'Data singer berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data singer tidak ada',
                );
            }
        }

        return ResponseFormatter::success(
            $singers,
            'Data singer berhasil diambil'
        );
    }
}
