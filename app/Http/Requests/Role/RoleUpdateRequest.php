<?php


namespace App\Http\Requests\Role;


use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:App\Models\Role,id,deleted,false',
            'name' => 'string',
            'description' => 'string|nullable',
            'permission_ids' => 'array|exists:App\Models\Permission,id,deleted,false',
        ];
    }

}
