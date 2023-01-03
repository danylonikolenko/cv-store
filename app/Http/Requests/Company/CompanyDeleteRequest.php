<?php


namespace App\Http\Requests\Company;


use Illuminate\Foundation\Http\FormRequest;

class CompanyDeleteRequest extends FormRequest
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
        ];
    }

}
