<?php

namespace Database\Seeders;

use App\Repositories\GeneralUsersRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GeneralUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(GeneralUsersRepository $repository): void
    {
        $repository->allHardDelete();

        $repository->factories(10);
    }
}
