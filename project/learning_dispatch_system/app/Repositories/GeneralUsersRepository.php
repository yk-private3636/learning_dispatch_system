<?php

namespace App\Repositories;

use App\Models\GeneralUser;
use App\Repositories\AbstractRepository;

class GeneralUsersRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return GeneralUser::class;
    }

    public function tableName(): string
    {
        return $this->model->getTable();
    }

    public function insert(array $insertData): bool
    {
        return $this->model->insert($insertData);
    }
}