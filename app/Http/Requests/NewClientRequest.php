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
            'business_name' => 'required',
            'business_type' => 'required',
            'business_address' => 'required',
            'business_telephone' => 'required',
            'representative_name' => 'required',
            'representative_address' => 'required',
            'final_accounts_month' => 'required',
            'contact_email_address' => 'required'
        ];
    }
}
