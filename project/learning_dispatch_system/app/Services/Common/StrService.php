<?php

namespace App\Services\Common;

use App\Exceptions\RetryThresholdExceedException;
use App\Repositories\ResetPasswordTokenRepository;
use Illuminate\Support\Str;

class StrService
{
	private const TOKEN_DIGITS = 60;
	private const RETRY_MIDDLE_NUM = 8;
	private const RETRY_MAX_NUM = 16;

	/** 下記メソッドは、PasswordResetAbstractに移動する **/
	public static function createToken(): string
	{
		$passwordResetToken = app()->make(ResetPasswordTokenRepository::class);
		$token = null;
		$tryCnt = 0;

		while ($token === null) {
			$tryCnt++;
			
			if($tryCnt > self::RETRY_MAX_NUM){
				throw new RetryThresholdExceedException();				
			}

			if($tryCnt === self::RETRY_MIDDLE_NUM){
				$passwordResetToken->expireTokenDelete();
			}
			
			$char = Str::random(self::TOKEN_DIGITS);
			$judge = $passwordResetToken->exists($char);
			
			if($judge) continue;

			$token = $char;
		}

		return $token;
	}

	public static function createUserId(): string
	{
		$digits = rand(8, 16);
		$strBytes = random_bytes($digits);
		$encode = base64_encode($strBytes);
		$userId = substr($encode, 0, $digits);

		return $userId;
	}
}