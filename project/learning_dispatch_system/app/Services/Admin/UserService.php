<?php

namespace App\Services\Admin;

use App\Dto\Interface\UserSearchDTOInterface;
use App\Models\AdminUser;
use App\Services\Abstract\UserAbstract;
use App\Utils\StructUtil;
use App\Repositories\AdminUsersRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends UserAbstract
{
    public function __construct(
        private AdminUsersRepository $adminUser
    )
    {}

    public function selectUsers(UserSearchDTOInterface $userDto): LengthAwarePaginator
    {
        $users = $this->adminUser->selectUserList($userDto);
        
        return StructUtil::paginate($users);
    }

    public function regist(array $registData): AdminUser
    {
        // これから実装予定
        // 一旦エラー回避のため、下記Model返却
        return new AdminUser();
    }
}