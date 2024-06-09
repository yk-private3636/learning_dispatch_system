<?php

namespace Tests\Feature\General;

use App\Models\GeneralUser;
use App\Repositories\GeneralUsersRepository;
use App\Services\Common\FilterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private GeneralUsersRepository $user;

    public function setup(): void
    {
        parent::setup();
        $this->user = app()->make(GeneralUsersRepository::class);
    }

    public function test_ログイン画面表示(): void
    {
        $resource = $this->get(route('general.login'));

        $resource->assertStatus(200);

        $resource->assertInertia();
    }

    /**
     * @dataProvider 入力データ
     *  
     */
    public function test_ログインバリデーション(array $postData): void
    {
        $response = $this->post(route('general.auth', $postData));

        $keys = array_keys(FilterService::blank($postData));

        $response->assertSessionHasErrors($keys);

        $response->assertStatus(302);
    }

    public function test_正常パターン(): void
    {
        $userData = GeneralUser::factory()->make()->toArray();

        $response = $this->post(route('general.auth'), $userData);

        /** top画面の実装をしたら、下記テストケースも変更する **/
        $response->assertRedirect();
    }

    public function test_ログアウト(): void
    {
        $user = $this->user->factories(1)->first();

        $this->actingAs($user, \UserEnum::GENERAL->guardName());
        $this->assertTrue(user() instanceof GeneralUser);

        $response = $this->get(route('logout'));

        $response->assertRedirect(route('general.login'));
        $this->assertTrue(__('message.successful.logout') === $response->getSession()->get('msg'));
        $this->assertTrue(user() === null);
    }

    public static function 入力データ(): array
    {
        return [
            'すべて空文字のパターン' => [
                [
                    'user_id'  => '',
                    'password' => ''
                ]
            ],
            'すべてnullのパターン' => [
                [
                    'user_id' => null,
                    'password' => null
                ]
            ],
            'パスワードが空の時' => [
                [
                    'user_id' => 'test',
                    'password' => ''
                ]
            ],
            'ユーザーIDが空の時' => [
                [
                    'user_id' => '',
                    'password' => 'test'
                ]
            ],
        ];
    }
}
