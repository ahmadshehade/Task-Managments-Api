<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Str;

class AuthenticationRequest extends FormRequest
{
    /**
     * Prepare data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'name' => Str::title(strip_tags($this->firstName) . ' ' . strip_tags($this->lastName)), // دمج الاسم الأول والاسم الأخير بشكل صحيح
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Summary of rules
     * @return array
     */
    public function rules(): array
    {
        $rules = [];  // بداية بالقواعد الفارغة

        if ($this->routeIs('register')) {
            $rules = array_merge($rules, [
                "name" => ['required', 'string', 'min:6', 'max:32'],
                "firstName" => ['required', 'string', 'min:3', 'max:16'],
                "lastName" => ['required', 'string', 'min:3', 'max:16'],
                "password" => ['required', 'min:6', 'max:32', 'confirmed'],
                "email" => ['required', 'email', 'unique:users,email'],
                 'rule' => ['required', 'string', 'in:admin,user'],

            ]);
        }

        if ($this->routeIs('login')) {
            $rules = array_merge($rules, [
                "email" => ['required', 'email', 'exists:users,email'],
                "password" => ['required', 'min:6', 'max:32'],
            ]);
        }

        return $rules;
    }

    /**
     * Get the custom validation messages for the request.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.max' => 'Password must be at most 32 characters.',
        ];

        if ($this->routeIs('register')) {
            $messages = array_merge($messages, [
                'name.required' => 'Name is required.',
                'name.string' => 'Name must be a string.',
                'name.min' => 'Name must be at least 6 characters.',
                'name.max' => 'Name must be at most 32 characters.',

                'firstName.required' => 'First name is required.',
                'firstName.string' => 'First name must be a string.',
                'firstName.min' => 'First name must be at least 3 characters.',
                'firstName.max' => 'First name must be at most 16 characters.',

                'lastName.required' => 'Last name is required.',
                'lastName.string' => 'Last name must be a string.',
                'lastName.min' => 'Last name must be at least 3 characters.',
                'lastName.max' => 'Last name must be at most 16 characters.',

                'email.unique' => 'The email has already been taken.',
                'password.confirmed' => 'Password confirmation does not match.',

                   'rule.required' => 'The role field is required.',
                   'rule.string' => 'The role field must be a valid string.',
                   'rule.in' => 'The role must be either "admin" or "user".',
            ]);
        }

        if ($this->routeIs('login')) {
            $messages = array_merge($messages, [
                'email.exists' => 'The email does not exist.',
            ]);
        }

        return $messages;
    }


   public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){

    throw new HttpClientException(
        response()->json([
            'message'=>'Validation failed.',
            'errors' => $validator->errors()->all(),
        ],422)
    );
   }

}
