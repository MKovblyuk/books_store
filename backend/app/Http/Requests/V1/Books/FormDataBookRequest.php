<?php

namespace App\Http\Requests\V1\Books;

use App\Exceptions\Http\FailedValidationHttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class NewBookRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidationHttpResponseException($validator);
    }

    protected function prepareForValidation()
    {
        $data = json_decode($this->data);

        if (isset($data->name)) {
            $this->merge(['name' => $data->name]);
        }
        if (isset($data->description)) {
            $this->merge(['description' => $data->description]);
        }
        if (isset($data->language)) {
            $this->merge(['language' => $data->language]);
        }
        if (isset($data->publicationYear)) {
            $this->merge(['publication_year' => $data->publicationYear]);
        }
        if (isset($data->coverImageUrl)) {
            $this->merge(['cover_image_url' => $data->coverImageUrl]);
        }
        if (isset($data->publisherId)) {
            $this->merge(['publisher_id' => $data->publisherId]);
        }
        if (isset($data->categoryId)) {
            $this->merge(['category_id' => $data->categoryId]);
        }
        if (isset($data->authorsIds)) {
            $this->merge(['authors_ids' => $data->authorsIds]);
        }
        if (isset($data->formats)) {
            $this->merge(['formats' => $this->prepareFormatsForValidation($data->formats)]);
        }
        if (isset($this->coverImage)) {
            $this->merge(['cover_image' => $this->coverImage]);
        }
    }

    protected function prepareFormatsForValidation($formats): array
    {
        $preparedFormats = [];

        if (isset($formats->paper)) {
            $preparedFormats['paper'] = $this->preparePaperFormat($formats->paper);
        }
        if (isset($formats->electronic)) {
            $preparedFormats['electronic'] = $this->prepareElectronicFormat($formats->electronic);
        }
        if (isset($formats->audio)) {
            $preparedFormats['audio'] = $this->prepareAudioFormat($formats->audio);
        }
        
        return $preparedFormats;
    }

    protected function preparePaperFormat($format): array 
    {
        $preparedFormat = [];

        if (isset($format->pageCount)) {
            $preparedFormat['page_count'] = $format->pageCount;
        }
        if (isset($format->price)) {
            $preparedFormat['price'] = $format->price;
        }
        if (isset($format->discount)) {
            $preparedFormat['discount'] = $format->discount;
        }
        if (isset($format->quantity)) {
            $preparedFormat['quantity'] = $format->quantity;
        }


        return $preparedFormat;
    }

    protected function prepareElectronicFormat($format): array
    {
        $preparedFormat = [];

        if (isset($format->pageCount)) {
            $preparedFormat['page_count'] = $format->pageCount;
        }
        if (isset($this->electronicFiles)) {
            $preparedFormat['files'] = $this->electronicFiles;
        }
        if (isset($format->price)) {
            $preparedFormat['price'] = $format->price;
        }
        if (isset($format->discount)) {
            $preparedFormat['discount'] = $format->discount;
        }

        return $preparedFormat;
    }

    protected function prepareAudioFormat($format): array
    {
        $preparedFormat = [];

        if (isset($this->audioFiles)) {
            $preparedFormat['files'] = $this->audioFiles;
        }
        if (isset($format->price)) {
            $preparedFormat['price'] = $format->price;
        }
        if (isset($format->discount)) {
            $preparedFormat['discount'] = $format->discount;
        }
        if (isset($format->duration)) {
            $preparedFormat['duration'] = $format->duration;
        }

        return $preparedFormat;
    }
}
