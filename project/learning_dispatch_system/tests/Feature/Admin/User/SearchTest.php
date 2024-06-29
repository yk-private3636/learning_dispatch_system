<?php

namespace Tests\Feature\Admin\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\Auth;
use App\Repositories\AdminUsersRepository;

class SearchTest extends TestCase
{
    use RefreshDatabase, Auth;

    private AdminUsersRepository $user;

    public function setup(): void
    {
        parent::setup();
        $this->user = app()->make(AdminUsersRepository::class);
    }

    public function test_全件ユーザーリスト取得(): void
    {
        $this->Authenticating();

        $this->user->factories(20);

        $response = $this->getJson(route('admin.userList.index'));

        $response->assertStatus(200);

        $result = $response['users'];

        $this->assertEquals($result['current_page'], 1);
        $this->assertEquals($result['per_page'], 20);
        $this->assertEquals(count($result['data']), 20);
        $this->assertEquals($result['total'], 21);
    }
}
