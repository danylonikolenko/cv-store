<?php


namespace App\Http\Requests\Permission;


use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:App\Models\Permission,id,deleted,false',
            'description' => 'string|nullable',
            'function_name' => 'string|nullable',
            'class_name' => 'string|nullable',
            'route' => 'string|nullable',
        ];
    }


}
