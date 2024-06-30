<?php

namespace Tests\Feature\Admin\User;

use App\Http\Requests\Traits\EmailRule;
use App\Http\Requests\Traits\UserNameRule;
use App\Repositories\AdminUsersRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\Auth;
use Illuminate\Support\Str;

class SearchTest extends TestCase
{
    use RefreshDatabase, Auth;
    use EmailRule, UserNameRule;

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

    /**
     * @dataProvider 入力データ_管理者ユーザー検索用
     */
    public function test_ユーザー検索(array $user): void
    {
        $auth = $this->Authenticating();

        $this->user->factories(1, $user);

        $reqUrl = route('admin.userList.index') . '?page=1';
        
        $user = [
            ...$user,
            'name' => $user['family_name'] . ' ' . $user['name']
        ];

        unset($user['family_name'], $user['password']);
        $keys = array_keys($user);

        foreach($keys as $key){
            $reqUrl .= "&{$key}={$user[$key]}";
        }

        $response = $this->getJson($reqUrl);
        $response->assertStatus(200);

        $result = $response['users'];
        $this->assertEquals(count($result['data']), 1);
    }
    
    /**
     * @dataProvider 入力データ_管理者ユーザー検索_バリデーションチェック用
     */
    public function test_バリデーションチェック(array $inputs): void
    {
        $this->Authenticating();

        $reqUrl = route('admin.userList.index');

        foreach($inputs as $key => $input){
            $judge = $key === array_key_first($inputs);
            
            $reqUrl .= $judge ? '?page=1&' : '&';
            $reqUrl .= "{$key}={$input}";
        }

        $response = $this->getJson($reqUrl);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(array_keys($inputs));
    }

    public static function 入力データ_管理者ユーザー検索_バリデーションチェック用(): array
    {
        return [
            'メールアドレス文字数制限' => [
                'inputs' => [
                    'email' => Str::random(self::EMAIL_MAX_DIGITS + 1),
                ]
            ],
            '名前文字数制限' => [
                'inputs' => [
                    'name'  => Str::random(self::USER_FULL_NAME_DIGITS + 1),
                ]
            ],
            '利用ステータスenum check' => [
                'inputs' => [
                    'usageStatus'  => 9999,
                ]
            ],
            'すべての項目' => [
                'inputs' => [
                    'email' => Str::random(self::EMAIL_MAX_DIGITS + 1),
                    'name'  => Str::random(self::USER_FULL_NAME_DIGITS + 1),
                    'usageStatus'  => 9999,
                ]
            ]
        ];
    }

    public static function 入力データ_管理者ユーザー検索用(): array
    {
        return [
            'sample1' => [
                'user' => [
                    'email' => 'feature-test@gmail.com',
                    'password' => 'test',
                    'family_name' => 'ユニットテスト1',
                    'name'  => '太郎',
                    'usage_status' => 1
                ]
            ],
            'sample2' => [
                'user' => [
                    'email' => 'feature-test2@gmail.com',
                    'password' => 'test',
                    'family_name' => 'ユニットテスト2',
                    'name'  => '太郎',
                    'usage_status' => 2
                ]
            ]
        ];
    }
}
