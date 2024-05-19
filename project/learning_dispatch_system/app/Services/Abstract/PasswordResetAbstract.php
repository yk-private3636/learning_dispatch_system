<?php

namespace App\Services\Abstract;

use App\Exceptions\RetryThresholdExceedException;
use App\Jobs\SendMailJob;
use App\Mail\PasswordResetMail;
use App\Mail\PasswordResetGuideMail;
use App\Models\ResetPasswordToken;
use App\Repositories\ResetPasswordTokenRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;

abstract class PasswordResetAbstract
{

	private const TOKEN_DIGITS = 60;
	private const RETRY_MIDDLE_NUM = 8;
	private const RETRY_MAX_NUM = 16;

	public function __construct(
		private ResetPasswordTokenRepository $resetPasswordToken
	){}

	abstract protected function tokenHistroyCreate(string $email, string $token): ResetPasswordToken;
	abstract protected function reset(string $token, string $password): User;

	public function passResetGuideNotice(ResetPasswordToken $resetPasswordToken): void
	{
		$userDivision = $resetPasswordToken->user_division;
		$relations = $resetPasswordToken->getRelations();

		$relationKey = match ($userDivision) {
			\UserEnum::GENERAL->division() => \UserEnum::GENERAL->relationKey(),	
			\UserEnum::ADMIN->division()   => \UserEnum::ADMIN->relationKey(),	
		};

		if(Arr::exists($relations, $relationKey) === false){
			$resetPasswordToken = $this->resetPasswordToken->loads($resetPasswordToken, [$relationKey]);
		}

		$email = $resetPasswordToken->$relationKey->email;

		$mailObj = new PasswordResetGuideMail($resetPasswordToken);

		SendMailJob::dispatch($email, $mailObj);
	}

	public function passwordResetNotice(User $user): void
	{
		$email = $user->email;
		$mailObj = new PasswordResetMail($user);

		SendMailJob::dispatch($user->email, $mailObj);
	}

	protected function createToken(): string
	{
		$token = null;
		$tryCnt = 0;

		while ($token === null) {
			++$tryCnt;
			
			if($tryCnt > self::RETRY_MAX_NUM){
				throw new RetryThresholdExceedException();				
			}

			if($tryCnt === self::RETRY_MIDDLE_NUM){
				$this->resetPasswordToken->expireTokenDelete();
			}
			
			$char = Str::random(self::TOKEN_DIGITS);
			$judge = $this->resetPasswordToken->exists($char);
			
			if($judge) continue;

			$token = $char;
		}

		return $token;
	}

	protected function passwordResetUpdData(string $password): array
	{
		return [
			'password' => Hash::make($password)
		];
	}
}