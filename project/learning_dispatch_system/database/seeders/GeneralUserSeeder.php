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

        $insertData = $this->insertData();

        $repository->insert($insertData);
    }

    private function insertData(): array
    {
        return [
            [
                'user_id'      => 'test',
                'email'        => 'test@gmail.com',
                'password'     => Hash::make('test'),
                'family_name'  => 'テスト',
                'name'         => '太郎',
                'usage_status' => \CommonConst::ACCOUNT_USAGE,
                'created_at'   => now(),
                'updated_at'   => now(),
                'deleted_at'   => null,
            ],
            [
                'user_id'      => 'test2',
                'email'        => 'test2@gmail.com',
                'password'     => Hash::make('test'),
                'family_name'  => 'テスト',
                'name'         => '太郎2',
                'usage_status' => \CommonConst::ACCOUNT_USAGE,
                'created_at'   => now(),
                'updated_at'   => now(),
                'deleted_at'   => null,  
            ],
            [
                'user_id'      => 'test3',
                'email'        => 'test3@gmail.com',
                'password'     => Hash::make('test'),
                'family_name'  => 'テスト',
                'name'         => '太郎3',
                'usage_status' => \CommonConst::ACCOUNT_LEAVED,
                'created_at'   => now(),
                'updated_at'   => now(),
                'deleted_at'   => null,  
            ],
            [
                'user_id'      => 'test4',
                'email'        => 'test4@gmail.com',
                'password'     => Hash::make('test'),
                'family_name'  => 'テスト',
                'name'         => '太郎4',
                'usage_status' => \CommonConst::ACCOUNT_LOCKD,
                'created_at'   => now(),
                'updated_at'   => now(),
                'deleted_at'   => null,  
            ],
            [
                'user_id'      => 'test5',
                'email'        => 'test5@gmail.com',
                'password'     => Hash::make('test'),
                'family_name'  => 'テスト',
                'name'         => '太郎5',
                'usage_status' => \CommonConst::ACCOUNT_SUSPEND,
                'created_at'   => now(),
                'updated_at'   => now(),
                'deleted_at'   => null,  
            ],
            [
                'user_id'      => 'test6',
                'email'        => 'test6@gmail.com',
                'password'     => Hash::make('test'),
                'family_name'  => 'テスト',
                'name'         => '太郎6',
                'usage_status' => \CommonConst::ACCOUNT_DELETE_PENDING,
                'created_at'   => now(),
                'updated_at'   => now(),
                'deleted_at'   => now(),  
            ],
        ];
    }
}
