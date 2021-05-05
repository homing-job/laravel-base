<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * ログインした状態でアクセスできるかテスト
     *
     * @return void
     */
    public function testLogin()
    {
        // テストユーザー作成
        $user = User::factory()->make();
        // テストユーザーでhomeにアクセス
        $response = $this->actingAs($user)
                            ->get('/admin');
        // 正常にアクセスできるか?
        $response->assertStatus(200);
    }
}
