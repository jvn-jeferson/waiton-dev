<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'required',
            'company_address' => 'required',
            'company_rep' => 'required',
            'company_email' => 'required|unique:users,email',
            'company_rep_address' => 'required',
            'company_telephone' => 'required',
            'filing_month' => 'required',
            'business_type' => 'required',
            'company_nta_num' => 'required',
            'notify_for' => 'requried'
        ];
    }
}
