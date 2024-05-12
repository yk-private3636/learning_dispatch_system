<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\TokenRule;
use App\Http\Requests\Traits\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
    use TokenRule, PasswordRule;

    protected $stopOnFirstFailure = true;

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
            'password'        => $this->getPasswordRule(),
            'confirmPassword' => $this->getConfirmPasswordRule(),
            'token'           => $this->getTokenRule($this->path())
        ];
    }

    public function messages(): array
    {
        return [
            'password.required'                             => $this->passwordRequiredMsg(),
            'password.Illuminate\Validation\Rules\Password' => $this->passwordCombinMsg(),
            'confirmPassword.required'                      => $this->confirmPasswordRequiredMsg(),
            'confirmPassword.same'                          => $this->confirmPasswordSameMsg(),
        ];
    }
}
