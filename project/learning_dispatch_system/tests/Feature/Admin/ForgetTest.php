<?php

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use App\Models\ResetPasswordToken;
use App\Services\Admin\Login\PasswordResetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
        $response = $this->get(url('admin/login/forget'));

        $response->assertStatus(200);
    }

    /**
     * @dataProvider 入力データ
     */
    public function test_バリデーションチェック(?string $email): void
    {
        $response = $this->postJson(route('admin.procedure.password.reset'), [
            'email' => $email
        ]);

        // ステータスコード確認
        $response->assertStatus(422);

        // キー確認
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_パスワードリセット依頼(): void
    {
        AdminUser::factory()->create([
            'email' => $this->email
        ]);

        $response = $this->postJson(route('admin.procedure.password.reset'), [
            'email' => $this->email
        ]);

        $response->assertJsonMissingValidationErrors(['email']);
        $response->assertStatus(200);
    }

    public function test_リセット画面_トークン存在なしver(): void
    {
        $token = $this->service->createToken();
        $response = $this->getJson(route('admin.password.reset.accurate.token', $token));

        $response->assertStatus(404);
    }

    public function test_リセット画面_トークン存在ありver(): void
    {
        $token = $this->service->createToken();
        ResetPasswordToken::factory()->create([
            'email' => $this->email,
            'token' => $token,
            'user_division' => \UserEnum::ADMIN->division()
        ]);

        $response = $this->getJson(route('admin.password.reset.accurate.token', $token));

        $response->assertStatus(200);
    }

    /**
     * @dataProvider 入力データ_パスワードリセット_バリデーションチェック用
     */
    public function test_パスワードリセット_バリデーションチェック(array $putData, array $expect): void
    {
        $response = $this->putJson(route('admin.password.reset'), $putData);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors($expect);
    }

    public function test_パスワードリセット(): void
    {
        $token = $this->service->createToken();
        AdminUser::factory()->create([
            'email' => $this->email
        ]);

        ResetPasswordToken::factory()->create([
            'email' => $this->email,
            'token' => $token,
            'user_division' => \UserEnum::ADMIN->division()
        ]);

        $response = $this->putJson(route('admin.password.reset'), [
            'password' => $this->password,
            'confirmPassword' => $this->password,
            'token' => $token
        ]);

        $response->assertStatus(200);

        $response->assertJsonCount(1);

        $response->assertJsonFragment(['msg' => __('message.successful.passwordReset')]);

        $password = AdminUser::select('password')
            ->where('email', $this->email)
            ->first()
            ->password;

        $this->assertTrue(\Hash::check($this->password, $password));
    }

    public static function 入力データ(): array
    {
        return [
            '空の場合' => [
                'email' => ''
            ],
            'nullの場合' => [
                'email' => null
            ],
            'ドメインが無効の時' => [
                'email' => 'feature-test@gmail.comm'
            ],
            '存在しないメールアドレスの場合' => [
                'email' => 'not-found@gmail.com'
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
