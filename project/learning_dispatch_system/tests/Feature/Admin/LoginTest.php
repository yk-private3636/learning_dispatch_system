<?php

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private string $email;

    public function setup(): void
    {
        parent::setup();
        // $this->createApplication();
        $this->email = 'feature-test@gmail.com';
    }

    public function test_ログイン画面アクセス(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_認証成功パターン(): void
    {
        AdminUser::factory()->create([
            'email' => $this->email
        ]);

        $response = $this->postJson(route('admin.authentication'), [
            'email' => $this->email,
            'password' => 'test',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_認証失敗パターン(): void
    {
        $response = $this->postJson(route('admin.authentication'), [
            'email' => 'test@gmail.com',
            'password' => 'test1',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @dataProvider バリデーション用入力データ
     */
    public function test_バリデーションチェック(string $email, string $password): void
    {
        $response = $this->postJson(route('admin.authentication'), [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function バリデーション用入力データ(): array
    {
        return [
            'どちらも空の時' => [
                'email' => '', 
                'password' => '',
            ],
            'メールアドレスが空の時' => [
                'email' => '',
                'password' => '',
            ],
            'パスワードが空の時' => [
                'email' => 'test@gmail.com',
                'password' => '',
            ],
            'メールアドレスのドメインが無効の時' => [
                'email' => 'test@gmail.co',
                'password' => 'test',
            ]              
        ];
    }
}
