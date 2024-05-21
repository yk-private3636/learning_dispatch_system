<?php

namespace Tests\Feature\General;

// use App\Services\UserService;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_会員登録画面表示(): void
    {
        $response = $this->get(route('user.create'));

        $response->assertStatus(200);
        $response->assertInertia();
    }

    public function test_ユニークユーザーID自動生成(): void
    {
        $response = $this->getJson(route('general.user.id.create'));

        // ステータスコード
        $response->assertStatus(200);

        // キー確認
        $response->assertJson(function(AssertableJson $json){
            $json->has('user_id');
        });

        // ユーザーIDが指定した桁数範囲内で生成されているのか
        $json = $response->json();
        $len = strlen($json['user_id']);
        $this->assertEquals(true, $len >= 8 && $len <= 18);
    }
}
