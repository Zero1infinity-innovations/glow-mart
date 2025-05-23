<?php

namespace App\Http\Requests\Admin\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => ['required', 'numeric', 'min:0'],
            'unit' => 'required|in:Quantity,Gram,Kilogram,Milliliter,Liter',
            'image' => 'required|image|mimes: jpeg,pn,jpg,webp',
            'multi_image' => 'nullable|image|mimes: jpeg,pn,jpg,webp',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'category_id' => 'required|exists:categories.id',
            'status'=>'required'
        ];
    }

     /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'error' => $errors
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
