<?php

namespace App\Http\Requests;

use App\Models\Inserzione;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreInserzioneRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('inserzione_create');
    }

    public function rules()
    {
        return [
            'categoria_id' => [
                'required',
                'integer',
            ],
            'broker' => [
                'string',
                'required',
            ],
            'fondo_iniziale' => [
                'required',
            ],
            'fondo_finale' => [
                'required',
            ],
            'percentage' => [
                'numeric',
                'required',
            ],
            'estratto' => [
                'required',
            ],
        ];
    }
}
