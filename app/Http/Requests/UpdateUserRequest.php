<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'sometimes|string|max:255',
            'user_name' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|unique:users,email',
            'photo' => 'sometimes|image'
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.string' => 'Name must be string',
            'full_name.max' => 'Name is too big',

            'user_name.string' => 'User name must be string',
            'user_name.max' => 'User name is too big',

            'email.email' => 'Please enter an valid email',
            'email.unique' => 'Email must be unique',

            'photo.image' => 'Unsupported file'
        ];
    }
}
