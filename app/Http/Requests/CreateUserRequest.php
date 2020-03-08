<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|unique:users|email|max:255|string',
            'password' => 'required_unless:generate-password,1|nullable|min:8|string',
            'generate-password' => 'nullable',
            'description' => 'required|string',
            'profile_picture' => 'nullable|image',
            'role' => 'required|in:member,admin',
        ];
    }
}
