<?php

namespace App\Http\Requests\V1\Books;

use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        if (isset($this->publicationYear)) {
            $this->merge(['publication_year' => $this->publicationYear]);
        }
        if (isset($this->coverImageUrl)) {
            $this->merge(['cover_image_url' => $this->coverImageUrl]);
        }
        if (isset($this->publisherId)) {
            $this->merge(['publisher_id' => $this->publihserId]);
        }
        if (isset($this->categoryId)) {
            $this->merge(['category_id' => $this->categoryId]);
        }
        if (isset($this->authorsIds)) {
            $this->merge(['authors_ids' => $this->authorsIds]);
        }
        if (isset($this->formats)) {
            $this->merge(['formats' => $this->prepareFormatsForValidation($this->formats)]);
        }
    }

    protected function prepareFormatsForValidation(array $formats): array
    {
        $preparedFormats = [];

        if (isset($formats['paper'])) {
            $preparedFormats['paper'] = $this->preparePaperFormat($formats['paper']);
        }
        if (isset($formats['electronic'])) {
            $preparedFormats['electronic'] = $this->prepareElectronicFormat($formats['electronic']);
        }
        if (isset($formats['audio'])) {
            $preparedFormats['audio'] = $formats['audio'];
        }
        
        return $preparedFormats;
    }

    protected function preparePaperFormat(array $format): array 
    {
        if (isset($format['pageCount'])) {
            $format['page_count'] = $format['pageCount'];
        }

        return $format;
    }

    protected function prepareElectronicFormat(array $format): array
    {
        if (isset($format['pageCount'])) {
            $format['page_count'] = $format['pageCount'];
        }

        return $format;
    }
}
