<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CarStatusRequest extends FormRequest
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
            'temperature' => 'required|max:255',
            'origin' => 'required|max:255',
            'destination' => 'required|max:255',
            'next_station' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'temperature.required' => 'Suhu harus diisi.',
            'temperature.max' => 'Suhu tidak boleh lebih dari 255 karakter.',
            'origin.required' => 'Stasiun asal harus diisi.',
            'origin.max' => 'Stasiun asal tidak boleh lebih dari 255 karakter.',
            'destination.required' => 'Stasiun tujuan harus diisi.',
            'destination.max' => 'Stasiun tujuan tidak boleh lebih dari 255 karakter.',
            'next_station.required' => 'Stasiun berikutnya harus diisi.',
            'next_station.max' => 'Stasiun berikutnya tidak boleh lebih dari 255 karakter.',

        ];
    }
}
