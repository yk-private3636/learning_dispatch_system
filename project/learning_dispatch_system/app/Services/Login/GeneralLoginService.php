<?php

namespace App\Services\Login;

use App\Jobs\SendMailJob;
use App\Models\ResetPasswordToken;
use App\Mail\PasswordResetGuideMail;
use App\Repositories\ResetPasswordTokenRepository;
use App\Http\Requests\Login\LoginFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class GeneralLoginService
{
	public function __construct(
		private ResetPasswordTokenRepository $resetPasswordToken
	){}

	public function authenticationVerdict(LoginFormRequest $req): bool
	{
    	$credentials = $req->validated();

    	return auth()->attempt($credentials);
	}

	/**
	 * トークン発行履歴作成
	 * 
	 * @param string $email メールアドレス 
	 * @param string $token UUID
	 * @return \App\Models\ResetPasswordToken
	 */
	public function passResetProcedureRegistration(string $email, string $token): ResetPasswordToken
	{
        $insertData = $this->resetPasswordTokeniInsertData($email, $token);

        return $this->resetPasswordToken->create($insertData);
	}

	public function passResetGuideNotice(ResetPasswordToken $resetPasswordToken): void
	{
		$relations = $resetPasswordToken->getRelations();

		if(Arr::exists($relations, 'generalUser') === false){
			$resetPasswordToken = $this->resetPasswordToken->loads($resetPasswordToken, ['generalUser']);
		}

		$email = $resetPasswordToken->generalUser->email;
		$mailObj = new PasswordResetGuideMail($resetPasswordToken);

		SendMailJob::dispatch($email, $mailObj);
	}

	private function resetPasswordTokeniInsertData(string $email, string $token): array
	{
		return [
			'email' => $email,
			'token' => $token,
			'user_division' => \UserEnum::GENERAL->division()
		];
	}
}