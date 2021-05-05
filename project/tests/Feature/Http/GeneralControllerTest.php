<?php

namespace Tests\Feature\Http;

use App\Models\User;
use App\Models\General;
//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Constant\Session;

class GeneralControllerTest extends TestCase
{
    // テストスタート前にマイグレーションを実行し、終了後にロールバックして初期状態に戻す
    // 時間がかかるようなら「DatabaseTransactions」使ったほうがいいかも
    use DatabaseTransactions;
//    // テスト用にcsrfを無効
//    use WithoutMiddleware;
    /**
     * 一覧データ取得テスト
     *
     * @return void
     */
    public function testIndex()
    {
        // テストデータを作成
        $general1 = $this->createTestGeneral();
        $general2 = $this->createTestGeneral();
        // アクセス
        $response = $this->actingAs($this->makeTestUser())
                          ->post('/general/index/');
        // ステータスチェック
        $response->assertStatus(200);
        // テストデータが登録されているかチェック
        $this->assertDatabaseHas('generals', $general1->toArray());
        $this->assertDatabaseHas('generals', $general2->toArray());
    }
    
    /**
     * 登録テスト
     *
     * @return void
     */
    public function testStore()
    {
        // テストデータ作成
        $general = General::factory()->make()->toArray();
        // アクセス
        $response = $this->actingAs($this->makeTestUser())
                         ->post('/general/store/', $general);
        // ステータスチェック
        $response->assertStatus(200);
        // テストデータが登録されているかチェック
        $this->assertDatabaseHas('generals', $general);
    }
    
    /**
     * 削除テスト
     *
     * @return void
     */
    public function testDestroy()
    {
        // テストデータ作成
        $general = $this->createTestGeneral();
        // テストデータが登録されているかチェック
        $this->assertDatabaseHas('generals', $general->toArray());
        
        // アクセス
        $response = $this->actingAs($this->makeTestUser())
                         ->delete('/general/'. $general->id. '/');
        // ステータスチェック
        $response->assertStatus(200);
        // テストデータが削除されているかチェック
        $this->assertSoftDeleted('generals', $general->toArray());
    }
    
    /**
     * 更新テスト
     *
     * @return void
     */
    public function testUpdate()
    {
        // テストデータ作成
        $general = $this->createTestGeneral();
        // テストデータが登録されているかチェック
        $this->assertDatabaseHas('generals', $general->toArray());
        
        // 変更前データ保持
        $genral_before = General::find($general->id)->toArray();
        
        $general->kbn = Str::random(10);
        // アクセス
        $response = $this->actingAs($this->makeTestUser())
                         ->put('/general/'. $general->id. '/', $general->toArray());
        // ステータスチェック
        $response->assertStatus(200);
        
        // 変更後データ取得
        $genral_after = General::find($general->id)->toArray();
        
        // 変更チェック
        $this->assertTrue($genral_before !== $genral_after);
    }
    
    /**
     * エクセルデータ取得テスト
     *
     * @return void
     */
    public function testExportExcel()
    {
        // アクセス
        $response = $this->actingAs($this->makeTestUser())
                         ->post('/general/export_excel/');
        // ダウンロードファイルの名称チェック
        $this->assertTrue(strpos($response->headers->get('content-disposition'), 'generals.xlsx') !== false);
        // ステータスチェック
        $response->assertStatus(200);
    }
    
    /**
     * 条件セッションセット テスト
     *
     * @return void
     */
    public function testSetConds($data = null)
    {
        if(empty($data)){
            $data = ['kbn' => '1', 'value' => 'test_value'];
        }
        $response = $this->actingAs($this->makeTestUser())
                         ->post('/general/set_conds/', $data);
        $response->assertSessionHas(Session::MASTER_GENERAL_LIST_CONDS, $data);
    }
    
    /**
     * 条件セッション取得 テスト
     *
     * @return void
     */
    public function testGetConds()
    {
        $data = ['kbn' => '1', 'value' => 'test_value'];
        $this->testSetConds($data);
        $response = $this->actingAs($this->makeTestUser())
                         ->post('/general/get_conds/');
        $response->assertJson($data);
    }
    
    /**
     * 汎用マスタテストデータ作成
     *
     * @return void
     */
    private function createTestGeneral() : General{
        return General::factory()->create();
    }
    
    /**
     * 認証用ユーザー作成
     *
     * @return void
     */
    private function makeTestUser() : User{
        return User::factory()->make();
    }
}
