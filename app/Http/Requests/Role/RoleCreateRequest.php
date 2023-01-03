<?php


namespace App\Http\Requests\Role;


use Illuminate\Foundation\Http\FormRequest;

class RoleCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'string|nullable',
            'permission_ids' => 'array|exists:App\Models\Permission,id',
        ];
    }

}
