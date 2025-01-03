<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\Books\AudioFormat;

class StoreAudioFormatRequest extends AudioFormatRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return (new AudioFormat())->postRules();
    }
}
