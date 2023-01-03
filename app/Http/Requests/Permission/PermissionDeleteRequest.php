<?php


namespace App\Http\Requests\Permission;


use Illuminate\Foundation\Http\FormRequest;

class PermissionDeleteRequest extends FormRequest
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
        ];
    }

}
