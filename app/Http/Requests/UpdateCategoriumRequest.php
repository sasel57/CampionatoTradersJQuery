<?php

namespace App\Http\Requests;

use App\Models\Categorium;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCategoriumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('categorium_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
