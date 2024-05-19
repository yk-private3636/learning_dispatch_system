<?php

namespace App\Http\Requests\Admin\Login;

use App\Http\Requests\Traits\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
{
    use EmailRule;

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
            'email'    => $this->getEmailRule(),
            'password' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => $this->getEmailRequiredMsg(),
            'email.max'         => $this->getEmailMaxMsg(),
            'email.email'       => $this->getEmailCombinMsg(),
            'email.exists'      => $this->getEmailExistsMsg(),
            'password.required' => __('validate.required')
        ];
    }
}
