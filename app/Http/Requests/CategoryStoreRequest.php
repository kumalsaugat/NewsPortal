<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
        $rules = [
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($this->route('id')) {
            $rules['name'] = 'required|unique:categories,name,' . $this->route('id');
            $rules['slug'] = 'required|unique:categories,slug,' . $this->route('id');
        }

        return $rules;
    }
}
