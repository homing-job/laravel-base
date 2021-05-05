<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use App\Models\General;
use App\Models\User;
use Tests\DuskTestCase;

class GeneralMasterTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    CONST pause_time_1 = 8000;
    CONST pause_time_2 = 5000;
    CONST pause_time_3 = 1000;
    
    /**
     * 一覧が表示テスト
     *
     * @return void
     */
    public function testIndex(General $general = null)
    {
        if(empty($general)){
            // テストデータ作成
            $general = General::factory()->create();
        }
        
        $this->browse(function (Browser $browser) use($general){
            // テストユーザー作成
            $user = User::factory()->create();
            // ホームにアクセス
            $browser->loginAs($user)->visit('/admin');
            // 汎用マスタ画面に移動
            $browser->assertSee('マスタ')
                    ->clickLink('マスタ')
                    ->pause(self::pause_time_3)
                    ->assertSee('汎用マスタ')
                    ->clickLink('汎用マスタ');
            $browser->pause(self::pause_time_2);
            // テストデータが見える
            $browser->assertSee($general->kbn)
                    ->assertSee($general->value)
                    ->assertSee($general->sort_no);
        });
    }
    
    /**
     * 削除テスト
     *
     * @return void
     */
    public function testDelete()
    {
        // テストデータ作成
        $general = General::factory()->create();
        // 一覧表示テスト
        $this->testIndex($general);
        
        $this->browse(function (Browser $browser) use($general){
            // テストデータの削除ボタンを押下
            $browser->with('.table', function ($table) use($general){
                $table->assertSee($general->kbn)
                        ->assertSee($general->value)
                        ->assertSee($general->sort_no)
                        ->press('削除');
            });
            $browser->pause(self::pause_time_1);
            // 削除警告ダイアログ OK押下
            $browser->press('OK');
            $browser->pause(self::pause_time_2);
            // 登録したテストデータが見えないか？
            $browser->with('.table', function ($table) use($general){
                $table->assertDontSee($general->kbn)
                        ->assertDontSee($general->value)
                        ->assertDontSee($general->sort_no);
            });
        });
    }
    
    /**
     * 新規登録テスト
     *
     * @return void
     */
    public function testCreate()
    {
        $this->browse(function (Browser $browser){
            // テストユーザー作成
            $user = User::factory()->create();
            // ホームにアクセス
            $browser->loginAs($user)->visit('/admin');
            // 汎用マスタ画面に移動
            $browser->assertSee('マスタ')
                    ->clickLink('マスタ')
                    ->pause(self::pause_time_3)
                    ->assertSee('汎用マスタ')
                    ->clickLink('汎用マスタ');
            $browser->pause(self::pause_time_1);
            $browser->screenshot('1');
            
            // 新規登録ボタン押下
            $browser->press('新規作成');
            $browser->pause(self::pause_time_2);
            $browser->screenshot('2');
            // 新規登録用データ
            $kbn_input = '新規登録_区分';
            $value_input = '新規登録_値';
            $sortno_input = 888888888;
            // 新規登録
            $browser->type('#kbn', $kbn_input)
                    ->type('#value', $value_input)
                    ->type('#sort_no', $sortno_input)
                    ->press('登録');
            $browser->screenshot('3');
            $browser->pause(self::pause_time_2);
            // 登録したテストデータが見えるか？
            $browser->with('.table', function ($table) use($kbn_input, $value_input, $sortno_input){
                $table->assertSee($kbn_input)
                        ->assertSee($value_input)
                        ->assertSee($sortno_input);
            });
            $browser->screenshot('4');
        });
    }
    
    /**
     * 更新テスト
     *
     * @return void
     */
    public function testUpdate()
    {
        // テストデータ作成
        $general = General::factory()->create();
        // 一覧表示テスト
        $this->testIndex($general);
        
        $this->browse(function (Browser $browser) use($general){
            // テストデータの削除ボタンを押下
            $browser->with('.table', function ($table) use($general){
                $table->assertSee($general->kbn)
                        ->assertSee($general->value)
                        ->assertSee($general->sort_no)
                        ->press('編集');
            });
            $browser->pause(self::pause_time_1);
            // 更新
            $value_input = '更新_変更';
            $browser->type('#value', $value_input)
                    ->press('登録');
            $browser->pause(self::pause_time_2);
            // 登録したテストデータが見えるか？
            $browser->with('.table', function ($table) use($value_input, $general){
                $table->assertSee($value_input)
                      ->assertDontSee($general->value);
            });
        });
    }
    
    /**
     * excel出力テスト
     *
     * @return void
     */
    public function testExportExcel()
    {
        // 一覧表示テスト
        $this->testIndex();
        
        $this->browse(function (Browser $browser){
            $browser->press('マスタ出力');
            // ダウンロードファイルの名称判定が不明・・・
            // Featureテストの方でurlチェックしてるから不要?
        });
    }
}
