<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SingerRequest extends FormRequest
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
            'name' => 'required|max:255',
            'file' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama artis harus diisi.',
            'name.max' => 'Nama artis tidak boleh lebih dari 255 karakter.',
            'files.required' => 'Foto profile tidak boleh kosong',
        ];
    }
}
