<?php

namespace Tests\Feature\Http;

use App\Models\User;
use App\Models\Kyogi;
use App\Models\KyogiPlan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

// 申込画面apiテスト
class ReceptionControllerTest extends TestCase
{
    // テストスタート前にマイグレーションを実行し、終了後にロールバックして初期状態に戻す
    use DatabaseTransactions;
    
    /**
     * 申込画面表示テスト
     *
     * @return void
     */
    public function testIndex()
    {
        // アクセス(未ログイン)
        $response = $this->post('/reception', ['agree'=>true]);
        // ステータスチェック
        $response->assertStatus(200);
        
        // アクセス(ログイン済)
        $response = $this->actingAs($this->makeTestUser())
                         ->post('/reception', ['agree'=>true]);
        // ステータスチェック
        $response->assertStatus(200);
    }
    
    /**
     * 競技情報取得テスト
     *
     * @return void
     */
    public function testgetKyogis()
    {
        // 競技情報作成
        $kyogi = Kyogi::factory()->create();
        KyogiPlan::create(['kyogi_id' => $kyogi->id, 'kyogi_date' => '2020-10-01']);
        $checkData = Kyogi::with('kyogiPlans')->get()->first()->toArray();
        // 作成したデータが返ってくるかチェック
        $response = $this->get('/reception/kyogis');
        $response->assertStatus(200)
                 ->assertJsonFragment($checkData);
    }
    
    /**
     * 競技名称取得テスト
     *
     * @return void
     */
    public function testgetKyogiNms()
    {
        // 競技情報作成
        $kyogi = Kyogi::factory()->create();
        $response = $this->get('/reception/kyogis_nm');
        // 作成したデータが返ってくるかチェック
        $response->assertStatus(200)
                 ->assertJsonFragment([$kyogi->id => $kyogi->kyogi_nm]);
    }
    
    /**
     * バリデーションテスト
     *
     * @return void
     */
    public function testValidation()
    {
        $repository = new \App\Repositories\Content\ReceptionRepository();
        $service = new \App\Services\Content\ReceptionService($repository);
        // 競技情報作成
        $kyogi = Kyogi::factory()->create();
        $response = $this->post('/reception/validation', $service->getInputData());
        $response->assertStatus(400);
    }
    
    /**
     * 登録用データ取得テスト
     *
     * @return void
     */
    public function testInitData()
    {
        $repository = new \App\Repositories\Content\ReceptionRepository();
        $service = new \App\Services\Content\ReceptionService($repository);
        $response = $this->post('/reception/init_data');
        $response->assertStatus(200)
                 ->assertJson($service->getInputData());
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
