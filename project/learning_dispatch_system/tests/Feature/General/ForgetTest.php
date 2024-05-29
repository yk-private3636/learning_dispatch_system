<?php

namespace Tests\Feature\General;

use App\Models\GeneralUser;
use App\Models\ResetPasswordToken;
use App\Services\Login\PasswordResetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ForgetTest extends TestCase
{
    use RefreshDatabase;

    private string $email = 'feature-test@gmail.com';
    private string $password = 'Feature_test_123';

    public function setup(): void
    {
        parent::setup();
        $this->service = app()->make(PasswordResetService::class);
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

    public function test_パスワードリセット依頼(): void
    {
        GeneralUser::factory()->create([
            'email' => $this->email
        ]);

        $response = $this->post(route('procedure.password.reset'), [
            'email' => $this->email,
        ]);

        $response->assertStatus(302);

        $response->assertSessionHasNoErrors(['email']);
     
        $response->assertRedirect(route('login.forget.show'));
    }

    public function test_リセット画面_トークン存在なしver(): void
    {
        $token = $this->service->createToken();
        $response = $this->get(route('password.reset.show', $token));

        $response->assertStatus(404);
    }

    public function test_リセット画面_トークン存在ありver(): void
    {
        $token = $this->service->createToken();
        ResetPasswordToken::factory()->create([
            'email' => $this->email,
            'token' => $token,
            'user_division' => \UserEnum::GENERAL->division()
        ]);

        $response = $this->get(route('password.reset.show', $token));

        $response->assertInertia();

        $response->assertStatus(200);
    }

    /**
     * @dataProvider 入力データ_パスワードリセット_バリデーションチェック用
     * 
     */
    public function test_パスワードリセット_バリデーションチェック(array $putData, array $expect): void
    {
        $response = $this->put(route('password.reset'), $putData);

        $response->assertStatus(302);

        $response->assertSessionHasErrors($expect);
    }

    public function test_パスワードリセット(): void
    {
        $token = $this->service->createToken();

        GeneralUser::factory()->create([
            'email' => $this->email
        ]);

        ResetPasswordToken::factory()->create([
            'email' => $this->email,
            'token' => $token,
            'user_division' => \UserEnum::GENERAL->division()
        ]);

        $response = $this->put(route('password.reset'), [
            'password' => $this->password,
            'confirmPassword' => $this->password,
            'token' => $token
        ]);

        $password = GeneralUser::select('password')
            ->where('email', $this->email)
            ->first()
            ->password;

        $this->assertTrue(\Hash::check($this->password, $password));
        $response->assertStatus(302);
        $response->assertRedirect(route('general.login'));
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

    public static function 入力データ_パスワードリセット_バリデーションチェック用(): array
    {
        return [
            'すべて空の場合' => [
                'put_data' => [
                    'password' => '',
                    'confirmPassword' => '',
                    'token' => '',
                ],
                'expect' => [
                    'password',
                    'confirmPassword',
                    'token'
                ]
            ],
            'パスワードの要件が満たせていたない場合' => [
                'put_data' => [
                    'password' => 'feature_test_123',
                    'confirmPassword' => 'feature_test_123',
                    'token' => 'feature-test-token'
                ],
                'expect' => [
                    'password',
                    'token'
                ]
            ],
            '確認用パスワードが不一致の場合' => [
                'put_data' => [
                    'password' => 'Feature_test_123',
                    'confirmPassword' => 'feature_test_123',
                    'token' => 'feature-test-token'
                ],
                'expect' => [
                    'confirmPassword',
                    'token'
                ]
            ],
        ];
    } 
}
