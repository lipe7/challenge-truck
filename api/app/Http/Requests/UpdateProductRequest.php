<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'creator' => 'sometimes|string',
            'product_name' => 'sometimes|string',
            'quantity' => 'sometimes|string',
            'brands' => 'sometimes|string',
            'categories' => 'sometimes|string',
            'labels' => 'sometimes|string',
            'cities' => 'nullable|string',
            'purchase_places' => 'sometimes|string',
            'stores' => 'sometimes|string',
            'ingredients_text' => 'sometimes|string',
            'traces' => 'sometimes|string',
            'serving_size' => 'sometimes|string',
            'serving_quantity' => 'sometimes|numeric',
            'nutriscore_score' => 'sometimes|numeric',
            'nutriscore_grade' => 'sometimes|string',
            'main_category' => 'sometimes|string',
        ];
    }
}
