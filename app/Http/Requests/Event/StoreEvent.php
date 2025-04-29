<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],

            'is_public' => [
                'required',
                'boolean',
            ],

        ];
    }
}
