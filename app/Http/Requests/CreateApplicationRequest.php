<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateApplicationRequest extends FormRequest
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
            'name' => 'required|max:100|string',
            // Make sure a number is added
            'address' => 'required|regex:/.+\d+.*/',
            'town' => 'required|string',
            // https://rgxdb.com/r/4W9GV8AC
            'postal_code' => 'required|regex:/^(?:NL-)?(\d{4})\s*([A-Z]{2})$/i',
            'phone' => 'required|string',
            'date_of_birth' => 'required|date',
            'description' => 'required|string',
            'person_picture' => 'required|image',
            'bike_picture' => 'required|image',
        ];
    }
}
