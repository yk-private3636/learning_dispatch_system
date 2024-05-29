<?php

namespace App\Rules;

use Closure;
use App\Repositories\ResetPasswordTokenRepository;
use Illuminate\Contracts\Validation\ValidationRule;

class ActivateTokenExistsCkRule implements ValidationRule
{
    public function __construct(
        private int $userDivision
    ){}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value === null){
            $fail(__('validate.rule.ActivateTokenExistsCkRule'));
            return;
        }

        $resetPasswordToken = app()->make(ResetPasswordTokenRepository::class);

        $judge = $resetPasswordToken->activateTokenExists($value, $this->userDivision);

        if($judge === false){
            $fail(__('validate.rule.ActivateTokenExistsCkRule'));
        }        
    }
}
