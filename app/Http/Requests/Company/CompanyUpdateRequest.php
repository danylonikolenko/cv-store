<?php


namespace App\Http\Requests\Company;


use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|int|exists:App\Models\Company,id,deleted,false',
            'name' => 'string|min:3|max:255|unique:App\Models\Company,name',
            'region' => 'string|min:3|max:255',
            'city' => 'string|min:3|max:255',
            'address' => 'string|min:3|max:255',
        ];
    }

}
