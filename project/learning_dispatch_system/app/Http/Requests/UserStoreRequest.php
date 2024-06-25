<?php

namespace App\Http\Requests;

use App\Consts\UsageStatusEnum;
use App\Services\Common\UrlService;
use App\Http\Requests\Traits\EmailRule;
use App\Http\Requests\Traits\UserIdRule;
use App\Http\Requests\Traits\PasswordRule;
use App\Http\Requests\Traits\UserNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
{
    use EmailRule, UserIdRule, PasswordRule;
    use UserNameRule;

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
        $path = $this->path();

        $judge = UrlService::adminSideJudge($path);

        return match ($judge) {
            true => [
                'email'       => $this->getAdminEmailRuleWithUnique(UsageStatusEnum::ACCOUNT_USAGE->value),
                'password'    => $this->getPasswordRule(),
                'family_name' => $this->getUserNameRule(),
                'name'        => $this->getUserNameRule(),
            ],
            false => [
                'email'       => $this->getEmailRuleWithUnique(UsageStatusEnum::ACCOUNT_USAGE->value),
                'user_id'     => $this->getUserIdRule(UsageStatusEnum::ACCOUNT_USAGE->value),
                'password'    => $this->getPasswordRule(),
                'family_name' => $this->getUserNameRule(),
                'name'        => $this->getUserNameRule(),
            ]
        };
    }

    public function messages(): array
    {
        return [
            'email.required' => $this->getEmailRequiredMsg(),
            'email.max'      => $this->getEmailMaxMsg(),
            'email.email'    => $this->getEmailCombinMsg(),
            'email.unique'   => $this->getEmailUniqueMsg(),
            'password.required' => $this->passwordRequiredMsg(),
            'password.' . Password::class => $this->passwordCombinMsg(),
            'user_id.required' => $this->getUserIdRequiredMsg(),
            'user_id.max' => $this->geUserIdMaxMsg(),
            'user_id.unique' => $this->geUserIdUniqueMsg(),
            'family_name.required' => $this->getUserNameRequiredMsg(),
            'family_name.string' => $this->getUserNameStringMsg(),
            'family_name.max' => $this->getUserNameMaxMsg(),
            'name.required' => $this->getUserNameRequiredMsg(),
            'name.string' => $this->getUserNameStringMsg(),
            'name.max' => $this->getUserNameMaxMsg(),
        ];
    }
}
