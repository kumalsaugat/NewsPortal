<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Elegant\Sanitizer\Sanitizer;
class NewsStoreRequest extends FormRequest
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
        $newsId = $this->route('news');

        return [
            'title' => 'required|max:255|unique:news,title,'.$newsId,
            'description' => 'required|string',
            'image' => 'nullable|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'status' => 'boolean',
        ];
    }


    protected function prepareForValidation()
    {
        // Define sanitization rules
        $sanitizer = new Sanitizer($this->all(), [
            'title' => 'trim|escape',
            'slug' => 'trim|escape',
        ]);

        // Replace request data with sanitized data
        $this->merge($sanitizer->sanitize());
    }
}