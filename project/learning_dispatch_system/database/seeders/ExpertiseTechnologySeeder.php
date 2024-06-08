<?php

namespace Database\Seeders;

use App\Repositories\ExpertiseTechnologyRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpertiseTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(ExpertiseTechnologyRepository $repository): void
    {
        $repository->allHardDelete();

        $repository->factories(5);
    }
}
