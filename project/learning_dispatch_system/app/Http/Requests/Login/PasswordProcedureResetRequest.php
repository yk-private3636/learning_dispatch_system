<?php

namespace App\Http\Requests\Login;

use App\Http\Requests\Traits\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordProcedureResetRequest extends FormRequest
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
            'email' => $this->getEmailRuleWithExists(\CommonConst::ACCOUNT_USAGE)
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => $this->getEmailRequiredMsg(),
            'email.email'       => $this->getEmailCombinMsg(),
            'email.exists'      => $this->getEmailExistsMsg(),
        ];
    }
}
