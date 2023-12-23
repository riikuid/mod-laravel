<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MusicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'singers_id' => 'required|integer',
            'poster' => 'required|image',
            'music' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul lagu harus diisi.',
            'title.max' => 'Judul lagu tidak boleh lebih dari 255 karakter.',
            'singers_id.required' => 'Penyanyi tidak boleh kosong',
            'poster.required' => 'Poster tidak boleh kosong',
            'music.required' => 'Musik tidak boleh kosong',
        ];
    }
}
