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
        
        $insertData = $this->insertData();

        $repository->insert($insertData);
    }

    private function insertData(): array
    {
        return [
            [
                'email'         => 'test@gmail.com',
                'password'      => Hash::make('test'),
                'family_name'   => 'テスト',
                'name'          => '太郎',
                'usage_status'  => \CommonConst::ACCOUNT_USAGE,
                'mistake_num'   => 0,
                'lock_duration' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ],
            [
                'email'         => 'test2@gmail.com',
                'password'      => Hash::make('test'),
                'family_name'   => 'テスト',
                'name'          => '太郎2',
                'usage_status'  => \CommonConst::ACCOUNT_USAGE,
                'mistake_num'   => 0,
                'lock_duration' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,  
            ],
            [
                'email'         => 'test3@gmail.com',
                'password'      => Hash::make('test'),
                'family_name'   => 'テスト',
                'name'          => '太郎3',
                'usage_status'  => \CommonConst::ACCOUNT_LEAVED,
                'mistake_num'   => 0,
                'lock_duration' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,  
            ],
            [
                'email'         => 'test4@gmail.com',
                'password'      => Hash::make('test'),
                'family_name'   => 'テスト',
                'name'          => '太郎4',
                'usage_status'  => \CommonConst::ACCOUNT_LOCKD,
                'mistake_num'   => 3,
                'lock_duration' => now()->addYear(),
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,  
            ],
            [
                'email'         => 'test5@gmail.com',
                'password'      => Hash::make('test'),
                'family_name'   => 'テスト',
                'name'          => '太郎5',
                'usage_status'  => \CommonConst::ACCOUNT_SUSPEND,
                'mistake_num'   => 9,
                'lock_duration' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,  
            ],
            [
                'email'         => 'test6@gmail.com',
                'password'      => Hash::make('test'),
                'family_name'   => 'テスト',
                'name'          => '太郎6',
                'usage_status'  => \CommonConst::ACCOUNT_DELETE_PENDING,
                'mistake_num'   => 0,
                'lock_duration' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => now(),  
            ],
        ];
    }
}
