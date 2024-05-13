<?php

namespace App\Services\Abstract;

use App\Exceptions\RetryThresholdExceedException;
use App\Services\Common\StrService;
use App\Repositories\GeneralUsersRepository;

abstract class UserAbstract
{
	private const RETRY_MIDDLE_NUM = 8;
	private const RETRY_MAX_NUM = 16;

	public function __construct(
		private GeneralUsersRepository $generalUser
	){}

	public function uniqueUserId(): string
	{
		$userId = null;
		$tryCnt = 0;

		while ($userId === null) {
			$tryCnt++;
			
			if($tryCnt > self::RETRY_MAX_NUM){
				throw new RetryThresholdExceedException();				
			}

			if($tryCnt === self::RETRY_MIDDLE_NUM){
				$passwordResetToken->expireTokenDelete();
			}
			
			$str = StrService::createUserId();
			$user = $this->generalUser->find($str);

			if($user !== null) continue;

			$userId = $str;
		}

		return $userId;
	}
}