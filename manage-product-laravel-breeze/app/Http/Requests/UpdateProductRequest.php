<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        // Get product ID from route model binding or route parameter
        $productId = $this->route('product')?->id ?? $this->route('product');

        return [
            'category_id'   => ['required', 'exists:categories,id'],
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],

            'price'         => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],

            'stock'         => ['required', 'integer', 'min:0'],

            'sku' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'sku')->ignore($productId),
            ],

            'weight'        => ['nullable', 'numeric', 'min:0'],
            'length'        => ['nullable', 'numeric', 'min:0'],
            'width'         => ['nullable', 'numeric', 'min:0'],
            'height'        => ['nullable', 'numeric', 'min:0'],

            'status'        => ['required', 'in:active,draft,inactive'],
            
            // New image validation rules for update
            'new_images'    => ['nullable', 'array'],
            'new_images.*'  => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max per image
            
            // Remove images validation
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['exists:product_images,id'],
        ];
    }

    /**
     * Custom validation error messages
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category.',
            'category_id.exists'   => 'The selected category is invalid.',

            'name.required' => 'The product name is required.',
            'name.max'      => 'The product name may not be greater than 255 characters.',

            'price.required' => 'The price field is required.',
            'price.numeric'  => 'The price must be a number.',
            'price.min'      => 'The price must be at least 0.',

            'compare_price.numeric' => 'The compare price must be a number.',
            'compare_price.min'     => 'The compare price must be at least 0.',

            'stock.required' => 'The stock field is required.',
            'stock.integer'  => 'The stock must be an integer.',
            'stock.min'      => 'The stock must be at least 0.',

            'sku.unique' => 'This SKU has already been taken.',

            'weight.numeric' => 'The weight must be a number.',
            'length.numeric' => 'The length must be a number.',
            'width.numeric'  => 'The width must be a number.',
            'height.numeric' => 'The height must be a number.',

            'status.required' => 'Please select a status.',
            'status.in'       => 'The selected status is invalid.',
            
            // New image validation messages
            'new_images.array'        => 'New images must be provided as an array.',
            'new_images.*.image'      => 'Each new file must be an image.',
            'new_images.*.mimes'      => 'Allowed image formats are: jpeg, png, jpg, gif.',
            'new_images.*.max'        => 'Each new image must not exceed 2MB.',
            
            // Remove images validation messages
            'remove_images.array'     => 'Remove images must be provided as an array.',
            'remove_images.*.exists'  => 'One or more selected images do not exist.',
        ];
    }
}