<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
        $usersId = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|email|max:255|unique:users,email,' . $usersId,
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            'image' => ['nullable', 'string'],
            'phone' => ['required','regex:/^[0-9]{10}$/',],
            'status' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'The phone number must be exactly 10 digits without spaces or special characters.',
        ];
    }
}
