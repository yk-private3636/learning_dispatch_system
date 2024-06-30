<?php

namespace App\Repositories\Interface;

use App\Dto\Interface\UserSearchDTOInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserInterfaceRepository
{
    public function selectUserList(UserSearchDTOInterface $dto): Collection;
}