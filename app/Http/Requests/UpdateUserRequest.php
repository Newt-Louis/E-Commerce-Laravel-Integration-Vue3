<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'id' => 'bail|required',
            'name' => ['bail','required','string','max:255',Rule::unique('users')->ignore($this->route('user'))],
            'email' => ['bail','required','email',Rule::unique('users')->ignore($this->route('user'))],
            'phone' => ['bail','required','between:10,10',Rule::unique('users')->ignore($this->route('user'))],
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
    public function attributes()
    {
        return [
          'id' => 'ID',
          'name' => 'User Name',
          'email' => 'Email',
          'phone' => 'Phone',
          'role_id' => 'Role',
        ];
    }
}
