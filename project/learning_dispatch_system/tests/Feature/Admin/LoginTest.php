<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * ログイン画面アクセスHTTPステータスコード確認
     * @test
     */
    public function resStatusCodeCheck(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * 認証チェック(成功パターン)
     * @test
     */
    public function authenticationSuccessCheck(): void
    {
        $response = $this->postJson(route('admin.authentication'), [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ]);

        $response->assertStatus(Response::HTTP_OK);

    }

    /**
     * 認証チェック(失敗パターン)
     * @test
     */
    public function authenticationFailCheck(): void
    {
        $response = $this->postJson(route('admin.authentication'), [
            'email' => 'test@gmail.com',
            'password' => 'test1',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }


    /**
     * バリデーションチェック
     * @test
     * @dataProvider loginInputPattern
     */
    public function validateCheck(string $email, string $password, bool $expected): void
    {
        $response = $this->postJson(route('admin.authentication'), [
            'email' => $email,
            'password' => $password,
        ]);

        if($expected === true){
            $response->assertStatus(Response::HTTP_OK);
        }
        else{
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public static function loginInputPattern(): array
    {
        return [
            'case1' => [
                'email' => '', 
                'password' => '',
                'expected' => false
            ],
            'case2' => [
                'email' => 'test@gmail.com',
                'password' => '',
                'expected' => false
            ],
            'case3' => [
                'email' => 'test@gmail.co',
                'password' => 'test',
                'expected' => false
            ],
            'case4' => [
                'email' => 'test@gmail.com',
                'password' => 'test',
                'expected' => true
            ],
              
        ];
    }
}
