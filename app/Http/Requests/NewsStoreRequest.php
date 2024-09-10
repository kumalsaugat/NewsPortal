<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
}