<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // filters
            'q' => ['nullable', 'string'],

            'price_from' => ['nullable', 'numeric', 'min:0', 'max:10000'],
            'price_to' => ['nullable', 'numeric', 'min:0', 'max:10000', 'gte:price_from'],

            'category_id' => ['nullable', 'array'],
            'category_id.*' => ['nullable', 'integer', 'exists:categories,id'],

            'in_stock' => ['nullable', 'boolean'],

            'rating_from' => ['nullable', 'numeric', 'min:1', 'max:5'],

            // sorting
            'sort' => ['nullable', 'array'],
            'sort.*' => ['nullable', 'in:price_asc,price_desc,rating_desc,newest'],
        ];
    }

    public function messages(): array
    {
        return [
            'q.string' => 'The search query must be a valid string.',
            'price_from.numeric' => 'The minimum price must be a number.',
            'price_to.numeric' => 'The maximum price must be a number.',
            'price_to.gte' => 'The maximum price must be greater than or equal to the minimum price.',
            'category_id.array' => 'Categories must be provided as an array.',
            'category_id.*.exists' => 'One or more selected categories are invalid.',
            'in_stock.boolean' => 'The in-stock filter must be true or false.',
            'rating_from.min' => 'The rating must be at least 1.',
            'rating_from.max' => 'The rating cannot be higher than 5.',
            'sort.*.in' => 'The selected sorting option is invalid.',
        ];
    }

}
