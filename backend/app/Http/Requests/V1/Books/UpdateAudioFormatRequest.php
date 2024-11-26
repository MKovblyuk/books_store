<?php

namespace App\Http\Requests\V1\Books;

use App\Rules\Books\AudioFormat;

class UpdateAudioFormatRequest extends PaperFormatRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return strtoupper($this->_method) === 'PUT' 
            ? (new AudioFormat())->postRules() 
            : (new AudioFormat())->patchRules();
    }
}
