<?php

namespace App\Services\Common;

use App\Exceptions\RetryThresholdExceedException;
use App\Repositories\ResetPasswordTokenRepository;
use Illuminate\Support\Str;

class StrService
{
	private const UUID_DIGITS = 60;
	private const RETRY_MIDDLE_NUM = 6;
	private const RETRY_MAX_NUM = 12;

	public static function createUuid(): string
	{
		$passwordResetToken = app()->make(ResetPasswordTokenRepository::class);
		$uuid = null;
		$tryCnt = 0;

		while ($uuid === null) {
			$tryCnt++;
			
			if($tryCnt > self::RETRY_MAX_NUM){
				throw new RetryThresholdExceedException();				
			}

			if($tryCnt === self::RETRY_MIDDLE_NUM){
				$passwordResetToken->expireTokenDelete();
			}
			
			$char = Str::random(self::UUID_DIGITS);
			$judge = $passwordResetToken->exists($char);
			
			if($judge) continue;

			$uuid = $char;
		}

		return $uuid;
	}
}