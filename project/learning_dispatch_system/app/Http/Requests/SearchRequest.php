<?php

namespace App\Http\Requests;

use App\Consts\UsageStatusEnum;
use App\Http\Requests\Traits\EmailRule;
use App\Http\Requests\Traits\UserNameRule;
use App\Http\Requests\Traits\UsageStatusRule;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    use EmailRule, UserNameRule, UsageStatusRule;
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
            'email' => $this->getAdminEmailAcceptRule(),
            'name'  => $this->getUserFullNameAcceptRule(),
            'usageStatus' => $this->getUsageStatusRule()
        ];
    }

    public function messages(): array
    {
        return [
            'email.max'         => $this->getEmailMaxMsg(),
            'name.string'       => $this->getUserNameStringMsg(),
            'name.max'          => $this->getUserFullNameMaxMsg(),
            'usageStatus.enum'  => $this->getUsageStatusEnumMsg()
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated();

        if($this->initValJudge === false){
            return $validated;
        }

        if($validated['usageStatus'] == \CommonConst::SELECT_INIT_VAL){
            $validated['usageStatus'] = UsageStatusEnum::ACCOUNT_USAGE->value;
        }

        return $validated;
    }
}
