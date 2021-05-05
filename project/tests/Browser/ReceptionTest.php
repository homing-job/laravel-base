<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use App\Models\General;
use App\Models\Kyogi;
use App\Models\User;
use App\Libs\Consts;
use Tests\DuskTestCase;

// 同意→申込→確認→完了→管理画面→申込状況→確認 までの流れテスト
class ReceptionTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    CONST pause_time_1 = 500;
    CONST pause_time_2 = 10000;
    CONST pause_time_3 = 5000;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }
    
    /**
     * 申込テスト
     *
     * @return void
     */
    public function testReception(General $general = null)
    {
        
        $this->browse(function (Browser $browser) use($general){
            $browser->maximize();
            // 【同意画面】
            $browser->visit('/agree');
            $browser->assertSee('注意事項に同意する')
                    ->check('agree')
                    ->screenshot('agree')
                    ->pause(self::pause_time_1)
                    ->assertSee('申込する')
                    ->press('申込する');
            $browser->pause(self::pause_time_2);
            
            // 申込競技 入力用データ
            $kyogi_id = 1;
            $kyogi_hope_date = '2021-10-23';
            $raizyo = Consts::move['公共交通機関'];
            $raizyo_kotukikan = Consts::koutukikan['路線バス'];
            $taizyo = Consts::move['自家用車'];
            $taizyo_number_plate = '11-22';
            // 代表者 入力用データ
            $member1 = ['first_nm' => '山田',
                        'last_nm' => '太郎',
                        'first_nm_kana' => 'ヤマダ',
                        'last_nm_kana' => 'タロウ',
                        'birthday' => '1993',
                        'birthday_month' => '3',
                        'birthday_day' => '21',
                        'sex' => Consts::sex['男'],
                        'post_cd' => '480-0101',
                        'prefectures_cd' => Consts::prefectures['愛知県'],
                        'address1' => '丹羽郡扶桑町山那',
                        'address2' => '110番地',
                        'tel_keitai' => '09099990888',
                        'tel_zitaku' => '0587932990',
                        'hope' => '希望内容1',
                        'email' => 'homing0321r4cfw@yahoo.co.jp'];
            // 申込者2 入力用データ
            $member2 = ['first_nm' => '佐藤',
                        'last_nm' => '真',
                        'first_nm_kana' => 'サトウ',
                        'last_nm_kana' => 'マコト',
                        'birthday' => '1991',
                        'birthday_month' => '5',
                        'birthday_day' => '6',
                        'sex' => Consts::sex['男'],
                        'post_cd' => '380-0801',
                        'prefectures_cd' => Consts::prefectures['長野県'],
                        'address1' => '長野市箱清水',
                        'address2' => '115番地',
                        'tel_keitai' => '08088888888',
                        'tel_zitaku' => '0587888888',];
            // 申込者3 入力用データ
            $member3 = ['first_nm' => '堀',
                        'last_nm' => 'よしお',
                        'first_nm_kana' => 'ホリ',
                        'last_nm_kana' => 'ヨシオ',
                        'birthday' => '1981',
                        'birthday_month' => '7',
                        'birthday_day' => '9',
                        'sex' => Consts::sex['男'],
                        'post_cd' => '910-0001',
                        'prefectures_cd' => Consts::prefectures['福井県'],
                        'address1' => '福井市大願寺',
                        'address2' => '199番地',
                        'tel_keitai' => '77777777777',
                        'tel_zitaku' => '0777937777',];
            // 申込者4 入力用データ
            $member4 = ['first_nm' => '堀川',
                        'last_nm' => '希恵',
                        'first_nm_kana' => 'ホリカワ',
                        'last_nm_kana' => 'キエ',
                        'birthday' => '1978',
                        'birthday_month' => '6',
                        'birthday_day' => '5',
                        'sex' => Consts::sex['女'],
                        'post_cd' => '910-0004',
                        'prefectures_cd' => Consts::prefectures['福井県'],
                        'address1' => '福井市宝永',
                        'address2' => '250番地',
                        'tel_keitai' => '66677778888',
                        'tel_zitaku' => '0557999999',];
            
            // 【申込画面】
            $browser->select('kyogi_nm', $kyogi_id)
                    ->pause(self::pause_time_1)
                    ->click($this->clickRadio('kyogi_hope_date', $kyogi_hope_date)) 
                    ->click($this->clickRadio('raizyo', $raizyo)) 
                    ->select('raizyo_kotukikan', $raizyo_kotukikan)
                    ->click($this->clickRadio('taizyo', $taizyo)) 
                    ->type('taizyo_number_plate', $taizyo_number_plate);
            // 代表者入力
            $this->inputReceptionMember($browser, 1, $member1);
            $browser->type('#member1 textarea[name="hope"]', $member1['hope'])
                    ->type('#member1 input[name="email"]',  $member1['email'])
                    ->type('#member1 input[name="email_confirm"]',  $member1['email']);
            // 申込者2 入力
            $browser->check('#member2 input[name="chk_multiple"]');
            $this->inputReceptionMember($browser, 2, $member2);
            // 申込者3 入力
            $browser->check('#member3 input[name="chk_multiple"]');
            $this->inputReceptionMember($browser, 3, $member3);
            // 申込者4 入力
            $browser->check('#member4 input[name="chk_multiple"]');
            $this->inputReceptionMember($browser, 4, $member4);
            
            $browser->pause(self::pause_time_2);
            parent::captureImage($browser, 'reception');
            
            $browser->press('確認画面へ進む')
                    ->pause(self::pause_time_1);
            
            // 【確認画面】
            $kyogi_nm = Kyogi::find($kyogi_id)->kyogi_nm;
            $browser->assertSee($kyogi_nm)
                    ->assertSee($kyogi_hope_date)
                    ->assertSee(Consts::move['公共交通機関'])
                    ->assertSee(Consts::getValue('move', $raizyo))
                    ->assertSee(Consts::getValue('koutukikan', $raizyo_kotukikan))
                    ->assertSee(Consts::getValue('move', $taizyo))
                    ->assertSee($taizyo_number_plate);
            $this->seeConfirmationReceptionMember($browser, $member1);
            $browser->assertSee($member1['tel_keitai'])
                    ->assertSee($member1['tel_zitaku'])
                    ->assertSee($member1['hope'])
                    ->assertSee($member1['email']);
            $this->seeConfirmationReceptionMember($browser, $member2);
            $this->seeConfirmationReceptionMember($browser, $member3);
            $this->seeConfirmationReceptionMember($browser, $member4);
            parent::captureImage($browser, 'confirm');
            
            $browser->press('入力画面に戻る')
                    ->pause(self::pause_time_2);
            parent::captureImage($browser, 'reception_re');
            
            $browser->press('確認画面へ進む')
                    ->pause(self::pause_time_1);
            parent::captureImage($browser, 'confirm_re');
            
            $browser->press('確定')
                    ->pause(self::pause_time_2);
            parent::captureImage($browser, 'complete');
            
            // テストユーザー作成
            $user = User::factory()->create();
            // 【管理画面】
            $browser->loginAs($user)->visit('/admin');
            // 【申込状況画面】
            $browser->assertSee('申込状況')
                    ->clickLink('申込状況')
                    ->pause(self::pause_time_3);
            $browser->assertSee($kyogi_nm);
            $this->seeReceptionStatusMember($browser, $member1);
            parent::captureImage($browser, 'reception_status');
            $browser->press('詳細')
                    ->switchToLastTab()
                    ->pause(self::pause_time_1);
            
            // 【詳細画面】
            $browser->assertSee($kyogi_nm)
                    ->assertSee($kyogi_hope_date)
                    ->assertSee(Consts::move['公共交通機関'])
                    ->assertSee(Consts::getValue('move', $raizyo))
                    ->assertSee(Consts::getValue('koutukikan', $raizyo_kotukikan))
                    ->assertSee(Consts::getValue('move', $taizyo))
                    ->assertSee($taizyo_number_plate);
            $this->seeConfirmationReceptionMember($browser, $member1);
            $browser->assertSee($member1['tel_keitai'])
                    ->assertSee($member1['tel_zitaku'])
                    ->assertSee($member1['hope'])
                    ->assertSee($member1['email']);
            $this->seeConfirmationReceptionMember($browser, $member2);
            $this->seeConfirmationReceptionMember($browser, $member3);
            $this->seeConfirmationReceptionMember($browser, $member4);
            parent::captureImage($browser, 'admin_confirm');
        });
    }
    
    // 申込者情報入力(申込画面)
    private function inputReceptionMember($browser, $no, $data){
        $browser->type('#member'. $no. ' input[name="first_nm"]', $data['first_nm'])
                ->type('#member'. $no. ' input[name="last_nm"]', $data['last_nm'])
                ->type('#member'. $no. ' input[name="first_nm_kana"]', $data['first_nm_kana'])
                ->type('#member'. $no. ' input[name="last_nm_kana"]', $data['last_nm_kana'])
                ->select('#member'. $no. ' select[name="birthday"]', $data['birthday'])
                ->select('#member'. $no. ' select[name="birthday_month"]', $data['birthday_month'])
                ->select('#member'. $no. ' select[name="birthday_day"]', $data['birthday_day'])
                ->select('#member'. $no. ' select[name="sex"]', $data['sex'])
                ->type('#member'. $no. ' input[name="post_cd"]', $data['post_cd'])
                ->click('#member'. $no. ' button[name="serach_address"]')
                ->pause(self::pause_time_1)
                ->assertValue('#member'. $no. ' select[name="prefectures_cd"]', $data['prefectures_cd'])
                ->assertValue('#member'. $no. ' input[name="address1"]', $data['address1'])
                ->type('#member'. $no. ' input[name="address2"]', $data['address2'])
                ->type('#member'. $no. ' input[name="tel_keitai"]', $data['tel_keitai'])
                ->type('#member'. $no. ' input[name="tel_zitaku"]', $data['tel_zitaku']);
    }

    // 申込者情報確認(確認画面)
    private function seeConfirmationReceptionMember($browser, $data){
        $browser->assertSee($data['first_nm'])
                ->assertSee($data['last_nm'])
                ->assertSee($data['first_nm_kana'])
                ->assertSee($data['last_nm_kana'])
                ->assertSee($data['birthday'])
                ->assertSee($data['birthday_month'])
                ->assertSee($data['birthday_day'])
                ->assertSee(Consts::getValue('sex', $data['sex']))
                ->assertSee($data['post_cd'])
                ->assertSee(Consts::getValue('prefectures', $data['prefectures_cd']))
                ->assertSee($data['address1'])
                ->assertSee($data['address2']);
    }
    
    // 申込者情報確認(申込状況)
    private function seeReceptionStatusMember($browser, $data){
        $browser->assertSee($data['first_nm'])
                ->assertSee($data['last_nm'])
                ->assertSee($data['tel_keitai'])
                ->assertSee($data['tel_zitaku']);
    }
    
    /**
     * ラジオボタンクリック用 css selecter
     *
     * @param string $name
     * @param string $value
     * @return string
     */
    private function clickRadio($name, $value) : string{
        return 'input[name='. $name. '][value="'. $value. '"] ~ *';
    }
}
