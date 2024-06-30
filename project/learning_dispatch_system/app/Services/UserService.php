<?php

namespace App\Services;

use App\Dto\Interface\UserSearchDTOInterface;
use App\Models\GeneralUser;
use App\Services\Abstract\UserAbstract;
use App\Repositories\GeneralUsersRepository;
use App\Utils\StructUtil;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends UserAbstract
{
	public function __construct(
		private GeneralUsersRepository $generalUser
	){
		parent::__construct($generalUser);
	}

	public function regist(array $registData): GeneralUser
	{
		$registData['password'] = Hash::make($registData['password']);

		return $this->generalUser->create([
			'user_id'     => $registData['user_id'],
			'email'       => $registData['email'],
			'password'    => $registData['password'],
			'family_name' => $registData['family_name'],
			'name'        => $registData['name'],
		]);
	}

    public function selectUsers(UserSearchDTOInterface $userDto): LengthAwarePaginator
    {
        $users = $this->generalUser->selectUserList($userDto);
        
        return StructUtil::paginate($users);
    }
}