<?php

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use App\Repositories\AdminUsersRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private AdminUsersRepository $user;

    private string $email = 'feature-test@gmail.com';

    public function setup(): void
    {
        parent::setup();
        $this->user = app()->make(AdminUsersRepository::class);
        // $this->createApplication();
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

    public function test_アカウント一時停止_step1(): void
    {
        for($i=1; $i<3; $i++){
            $response = $this->postJson(route('admin.authentication'), [
                'email' => 'test@gmail.com',
                'password' => 'test1'
            ]);

            if($i !== 3){
                $response->assertJsonFragment(['err_msg' => __('message.unsuccessful.auth')]);
            }
            else{
                $response->assertJsonFragment(['err_msg' => __('message.mistake.step_fir')]);
            }

            $response->assertStatus(401);
        }
    }

    public function test_アカウント一時停止_step2(): void
    {
        AdminUser::factory()->create([
            'email' => $this->email,
            'mistake_num' => 3
        ]);

        for($i=1; $i<3; $i++){
            $response = $this->postJson(route('admin.authentication'), [
                'email' => $this->email,
                'password' => 'test1'
            ]);

            if($i !== 3){
                $response->assertJsonFragment(['err_msg' => __('message.unsuccessful.auth')]);
            }
            else{
                $response->assertJsonFragment(['err_msg' => __('message.mistake.step_sec')]);
            }

            $response->assertStatus(401);
        }
    }

    public function test_アカウント一時停止_step3(): void
    {
        AdminUser::factory()->create([
            'email' => $this->email,
            'mistake_num' => 6
        ]);

        for($i=1; $i<3; $i++){
            $response = $this->postJson(route('admin.authentication'), [
                'email' => $this->email,
                'password' => 'test1'
            ]);

            if($i !== 3){
                $response->assertJsonFragment(['err_msg' => __('message.unsuccessful.auth')]);
            }
            else{
                $response->assertJsonFragment(['err_msg' => __('message.mistake.step_thi')]);
            }

            $response->assertStatus(401);
        }
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

    public function test_ログアウト(): void
    {
        $user = $this->user->factories(1)->first();

        $this->actingAs($user, \UserEnum::ADMIN->guardName());
        $this->assertTrue(user() instanceof AdminUser);
        session()->put('user', $user);

        $response = $this->getJson(route('admin.logout'));
        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'msg' => __('message.successful.logout')
                ]);

        $this->assertTrue(user() === null);
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
