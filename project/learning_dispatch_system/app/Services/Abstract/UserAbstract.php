<?php

namespace App\Services\Abstract;
use App\Exceptions\RetryThresholdExceedException;
use App\Mail\UserRegistMail;
use App\Jobs\SendMailJob;
use App\Services\Common\StrService;
use App\Repositories\AbstractRepository;
use Illuminate\Foundation\Auth\User;

abstract class UserAbstract
{
	private const RETRY_MAX_NUM = 20;

	public function __construct(
		private AbstractRepository $userRepository
	){}

	abstract public function regist(array $registData): User;

	public function uniqueUserId(): string
	{
		$userId = null;
		$tryCnt = 0;

		while ($userId === null) {
			++$tryCnt;
			
			if($tryCnt > self::RETRY_MAX_NUM){
				throw new RetryThresholdExceedException();				
			}
			
			$str = $this->createUserId();
			$user = $this->userRepository->find($str);

			if($user !== null) continue;

			$userId = $str;
		}

		return $userId;
	}

	public function registNotice(User $user): void
	{
		$email = $user->email;
		$mailObj = new UserRegistMail($user);

		SendMailJob::dispatch($email, $mailObj);
	}

	protected function createUserId(): string
	{
		$digits = rand(8, 18);
		$strBytes = random_bytes($digits);
		$encode = base64_encode($strBytes);
		$userId = substr($encode, 0, $digits);

		return $userId;
	}
}