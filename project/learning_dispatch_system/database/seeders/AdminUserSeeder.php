<?php

namespace Database\Seeders;

use App\Repositories\AdminUsersRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(AdminUsersRepository $repository): void
    {
        $repository->allHardDelete();
        
        $repository->factories(10);
    }
}
