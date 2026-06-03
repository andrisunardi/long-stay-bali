<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'image',
                'file',
                'mimes:jpg,jpeg,png,gif,webp',
                'max:12288',
            ],
        ];
    }
}
