<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Process the data before validation
     */
    protected function prepareForValidation()
    {
        /* when use FormData() to send request it only accept primitive type
          so that on vuejs have to JSON.stringify(instace||array||array with object)
          and when laravel receive this field laravel must decode for php to understand
          what data look like.
        */
        if ($this->has('product_details')) {
            $this->merge([
              'product_details' => json_decode($this->input('product_details'), true)
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'name' => ['bail','required','max:255','unique:products'],
          'description' => ['nullable'],
          'gender' => ['nullable',Rule::in(['unisex','gentlemen','lady'])],
          'origin' => ['nullable'],
          'item_type_id' => ['bail','required'],
          /* sometimes validation will ignore child property if the parent doesn't exist */
          'product_images' => ['sometimes','array'],
          'product_images.*' => ['image'],
          /* sometimes validation will ignore child property if the parent doesn't exist */
          'product_details' => ['sometimes','array'],
          'product_details.*.id' => ['required'],
          'product_details.*.price' => ['nullable'],
          'product_details.*.discount' => ['nullable'],
          'product_details.*.inventory' => ['nullable'],
          'product_details.*.supplier' => ['nullable'],
          /* sometimes validation will ignore child property if the parent doesn't exist */
          'product_details.*.collection' => ['sometimes','array'],
          'product_details.*.collection.*.id' => ['required'],
        ];
    }
    public function messages()
    {
        return [
          '*.required' => ':attribute cannot blank !',
          '*.unique' => ':attribute existed',
          'gender.in' => 'Gender only accepts allowed value!',
    ];
    }
    public function attributes()
    {
        return [
          'name' => 'Product title',
          'item_type_id' => 'Catalogue',
          'product_details.*.id' => 'Capacity',
          'product_details.*.collection.id' => 'Collection'
        ];
    }
}
