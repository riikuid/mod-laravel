<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MovieItemRequest extends FormRequest
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
            'duration' => 'required|integer',
            'thumbnail' => 'required|image',
            'file.*' => 'required|mimetypes:video/*'
            // 'path' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul harus diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'duration.required' => 'Durasi harus diisi.',
            'duration.integer' => 'Durasi harus berupa angka.',
            'thumbnail.required' => 'Thumbnail tidak boleh kosong.',
            'files.required' => 'Video tidak boleh kosong',
        ];
    }
}
