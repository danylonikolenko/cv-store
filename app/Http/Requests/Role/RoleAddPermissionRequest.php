<?php


namespace App\Http\Requests\Role;


use Illuminate\Foundation\Http\FormRequest;

class RoleAddPermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'role_id' => 'required|integer|exists:App\Models\Role,id,deleted,false',
            'permission_id' => 'required|integer|exists:App\Models\Permission,id,deleted,false',
        ];
    }

}
