<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MovieRequest extends FormRequest
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
            'files' => 'required|image',
            'genres_id' => 'required|integer',
            'description' => 'required',
            'release_year' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul harus diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'files.required' => 'Poster film tidak boleh kosong',
            'description.required' => 'Deskripsi harus diisi.',
            'release_year.required' => 'Tahun rilis harus diisi.',
            'release_year.integer' => 'Tahun rilis harus berupa angka.',
            'genres_id.required' => 'Genre harus dipilih.',
            'genres_id.integer' => 'Genre harus berupa angka.',
        ];
    }
}
