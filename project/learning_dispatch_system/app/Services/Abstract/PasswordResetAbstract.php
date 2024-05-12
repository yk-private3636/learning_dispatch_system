<?php

namespace App\Services\Abstract;

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

	protected function passwordResetUpdData(string $password): array
	{
		return [
			'password' => Hash::make($password)
		];
	}
}