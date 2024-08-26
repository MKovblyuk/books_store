<?php

namespace App\Http\Requests\V1\Books;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadCoverImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['required', File::types(['jpg', 'png', 'jpeg'])],
        ];
    }

 
}
