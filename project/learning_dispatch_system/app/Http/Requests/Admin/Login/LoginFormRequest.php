<?php

namespace App\Http\Requests\Admin\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
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
            'email'    => ['bail', 'required', 'email:rfc,dns'],
            'password' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => __('validate.required'),
            'email.email'       => __('validate.email'),
            'password.required' => __('validate.required')
        ];
    }
}
