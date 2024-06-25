<?php

namespace App\Services\Admin;

use App\Dto\User\AdminSearchDTO;
use App\Models\AdminUser;
use App\Services\Abstract\UserAbstract;
use App\Services\Common\StructService;
use App\Repositories\AdminUsersRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends UserAbstract
{
    public function __construct(
        private AdminUsersRepository $adminUser
    )
    {}

    public function selectUsers(AdminSearchDTO $userDto): LengthAwarePaginator
    {
        $users = $this->adminUser->selectUserList($userDto);
        
        return StructService::paginate($users);
    }


    public function regist(array $registData): AdminUser
    {
        // これから実装予定
        // 一旦エラー回避のため、下記Model返却
        return new AdminUser();
    }
}