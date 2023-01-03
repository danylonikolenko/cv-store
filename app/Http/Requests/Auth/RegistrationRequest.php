<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'unique:App\Models\User,email',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:30',
            ]
        ];
    }

}
