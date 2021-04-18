<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusTimingRequest extends FormRequest
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
            'arrival_timing' => 'numeric|required|max:50',
            'bus_stop_id' => 'numeric|required|max:50',
            'bus_id' => 'numeric|required|max:50',
        ];
    }
}
