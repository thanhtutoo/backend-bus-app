<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusStopRequest extends FormRequest
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
            'bus_stop_name' => 'string|required|max:50',
            'lat' => 'required|max:50',
            'lng' => 'required|max:50',
            'postal_code' => 'numeric|required|max:50',
        ];
    }
}
