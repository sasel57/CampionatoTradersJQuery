<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'username' => [
                'string',
                'required',
            ],
            'password' => [
                'required',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
            'address' => [
                'string',
                'required',
            ],
            'comune' => [
                'string',
                'required',
            ],
            'country' => [
                'string',
                'required',
            ],
            'cap' => [
                'string',
                'required',
            ],
            'phone' => [
                'string',
                'required',
            ],
            'is_active' => [
                'required',
            ],
        ];
    }
}
