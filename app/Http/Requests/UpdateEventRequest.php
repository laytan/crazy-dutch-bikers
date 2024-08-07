<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'title' => 'nullable|string|max:255|min:1',
            'description' => 'nullable|string|min:1|max:1000',
            'location' => 'nullable|string|min:1|max:255',
            'location_link' => 'nullable|url|max:255',
            'facebook_link' => 'nullable|url|max:255',
            'date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'time' => ['nullable', 'string', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'end_time' => ['nullable', 'string', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'picture' => 'nullable|image',
        ];
    }
}
