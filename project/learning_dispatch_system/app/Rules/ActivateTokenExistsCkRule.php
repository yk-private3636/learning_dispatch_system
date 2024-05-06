<?php

namespace App\Rules;

use Closure;
use App\Repositories\ResetPasswordTokenRepository;
use Illuminate\Contracts\Validation\ValidationRule;

class ActivateTokenExistsCkRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $resetPasswordToken = app()->make(ResetPasswordTokenRepository::class);

        $judge = $resetPasswordToken->activateTokenExists($value);

        if($judge === false){
            $fail(__('validate.rule.ActivateTokenExistsCkRule'));
        }        
    }
}
