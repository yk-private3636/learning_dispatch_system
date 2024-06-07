<?php

namespace App\Repositories;

use App\Models\ExpertiseTechnology;
use App\Repositories\AbstractRepository;

class ExpertiseTechnologyRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return ExpertiseTechnology::class;
    }
}