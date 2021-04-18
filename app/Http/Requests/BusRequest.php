<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusRequest extends FormRequest
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
            // I want to check the user if exists first
            // If exists, will pass the email for unique validation
            // This is efficient, rather than we creating another validation for create or update
            'bus_number' => 'required|max:50',
           
        ];
    }
}
