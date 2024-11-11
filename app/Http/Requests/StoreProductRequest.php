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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'name' => ['bail','required','maxlength:255','unique:products'],
          'description' => ['nullable'],
          'gender' => [Rule::in(['unisex','gentlemen','lady'])],
          'origin' => ['nullable'],
          'item_type_id' => ['bail','required'],
        ];
    }
    public function messages()
    {
        return [
          '*.required' => ':attribute cannot blank !',
          '*.unique' => ':attribute existed',
          'gender.in' => 'Gender only accepted value can be done !',
    ];
    }
    public function attributes()
    {
        return [
          'name' => 'Product title',
          'item_type_id' => 'Catalogue',
          'gender' => 'Gender',
        ];
    }
}
