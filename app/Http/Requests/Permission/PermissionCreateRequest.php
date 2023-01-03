<?php


namespace App\Http\Requests\Permission;


use Illuminate\Foundation\Http\FormRequest;

class PermissionCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'description' => 'string|nullable',
            'function_name' => 'required|string',
            'class_name' => 'required|string',
            'route' => 'required|string',
        ];
    }

}
