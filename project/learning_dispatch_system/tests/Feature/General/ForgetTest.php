<?php

namespace Tests\Feature\General;

use App\Models\GeneralUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ForgetTest extends TestCase
{
    use RefreshDatabase;

    private string $email;

    public function setup(): void
    {
        parent::setup();
        $this->email = 'feature-test@gmail.com';
    }

    public function test_パスワードリセット画面表示(): void
    {
        $response = $this->get(route('login.forget.show'));

        $response->assertStatus(200);

        $response->assertInertia();
    }
    
    /**
     * @dataProvider 入力データ
     */
    public function test_メールアドレスバリデーション(?string $email): void
    {
        $response = $this->post(route('procedure.password.reset'), [
            'email' => $this->email
        ]);

        $response->assertSessionHasErrors(['email']);

        $response->assertStatus(302);
    }

    public function test_パスワードリセット(): void
    {
        $email = 'feature-test@gmail.com';

        GeneralUser::factory()->create([
            'email' => $this->email
        ]);

        $response = $this->post(route('procedure.password.reset'), [
            'email' => $this->email,
        ]);

        $response->assertRedirect(route('login.forget.show'));
    }

    public static function 入力データ(): array
    {
        return [
            '空文字の場合' => [
                'email' => '',
            ],
            'nullの場合' => [
                'email' => null,
            ],
            'ドメインが無効の場合' => [
                'email' => 'test@test.comm',
            ],
            '存在しないメールアドレスの場合' => [
                'email' => 'not-found@gmail.com',
            ]
        ];
    }
}
