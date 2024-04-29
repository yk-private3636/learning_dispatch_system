<?php

namespace App\Repositories;

use App\Models\AdminUser;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

class AdminUsersRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return AdminUser::class;
    }

    public function tableName(): string
    {
        return $this->model->getTable();
    }

    public function insert(array $insertData): bool
    {
        return $this->model->insert($insertData);
    }

    public function update(AdminUser $adminUser, array $updData): AdminUser
    {
        return tap($adminUser)->update($updData);
    }

    public function updateThenRefresh(AdminUser $adminUser, array $updData): AdminUser
    {
        return tap($adminUser)->update($updData)->refresh();
    }
    
    public function whereUnique(string $email, ?int $usageStatus = null, ?bool $exeJudge = true): AdminUser|null|Builder
    {
        $query = $this->model->where('email', $email)
                ->where('usage_status', $usageStatus ?? \CommonConst::ACCOUNT_USAGE);

        return $exeJudge ? $query->first() : $query;
    }

    public function whereUniqueSharedLock(string $email, ?int $usageStatus = null): ?AdminUser
    {
        return $this->whereUnique($email, $usageStatus, false)
                ->sharedLock()
                ->first();
    }



}