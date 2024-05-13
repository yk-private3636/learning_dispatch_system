<?php

namespace App\Services;

use App\Services\Abstract\UserAbstract;
use App\Repositories\GeneralUsersRepository;

class UserService extends UserAbstract
{
	public function __construct(
		private GeneralUsersRepository $generalUser
	){
		parent::__construct($generalUser);
	}
}