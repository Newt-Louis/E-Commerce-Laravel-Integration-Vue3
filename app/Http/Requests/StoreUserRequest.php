<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'bail|required|string|max:255|unique:users',
            'email' => 'bail|required|email|unique:users',
            'phone' => 'bail|required|unique:users|between:10,10',
            'password' => 'required',
            'role_id' => 'required'
        ];
    }
    public function messages()
    {
        return [
          '*.required' => ':attribute cannot blank !',
          '*.unique' => ':attribute already exist !',
          'name.max' => 'Username too long !',
          'email.email' => 'Email not correct !',
          'phone.between' => 'Phone include only 10 character !'
        ];
    }
}
