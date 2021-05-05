<?php

namespace Tests\Unit\Request;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Content\ReceptionRequest;
use Tests\TestCase;
use App\Libs\Consts;
use App\Models\Reception;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReceptionRequestTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * カスタムリクエストのバリデーションテスト
     *
     * @param string 値
     * @param boolean 期待値(true:バリデーションOK、false:バリデーションNG)
     * @dataProvider dataproviderExample
     */
    public function testExample($data, $expect)
    {
        //入力項目（$item）とその値($data)
        $dataList = $data;

        $request = new ReceptionRequest();
        //フォームリクエストで定義したルールを取得
        $rules = $request->rules();
        //Validatorファサードでバリデーターのインスタンスを取得、その際に入力情報とバリデーションルールを引数で渡す
        $validator = Validator::make($dataList, $rules);
        
        //入力情報がバリデーショルールを満たしている場合はtrue、満たしていな場合はfalseが返る
        $result = $validator->passes();
        //期待値($expect)と結果($result)を比較
        $this->assertEquals($expect, $result);
    }

    public function dataproviderExample()
    {
        $this->createApplication();
        return [
            '正常(全て)' => ['request' => $this->baseInputData(), 'expect' => true], 
            'エラー(未入力)(競技名)' => ['request' => $this->kyogiIdCase1(), 'expect' => false], 
            'エラー(未入力)(競技希望日)' => ['request' => $this->kyogiHopeDateCase1(), 'expect' => false], 
            'エラー(未入力)(移動方法(開会式))' => ['request' => $this->raizyoMoveCase1(), 'expect' => false], 
            'エラー(桁数オーバー)(ナンバープレート(開会式))' => ['request' => $this->raizyoNumberPlateCase1(), 'expect' => false], 
            'エラー(桁数オーバー)(公共交通機関(開会式))' => ['request' => $this->raizyoKotukikanCase1(), 'expect' => false], 
            'エラー(未入力)(移動方法(閉会式))' => ['request' => $this->taizyoMoveCase1(), 'expect' => false], 
            'エラー(桁数オーバー)(ナンバープレート(閉会式))' => ['request' => $this->taizyoNumberPlateCase1(), 'expect' => false], 
            'エラー(桁数オーバー)(公共交通機関(閉会式))' => ['request' => $this->taizyoKotukikanCase1(), 'expect' => false], 
            'エラー(未入力)姓' => ['request' => $this->firstNmCase1(), 'expect' => false], 
            'エラー(未入力)名' => ['request' => $this->lastNmCase1(), 'expect' => false], 
            'エラー(全角ひらがな入力)姓(カナ) ' => ['request' => $this->firstNmKanaCase1(), 'expect' => false], 
            'エラー(全角ひらがな入力)名(カナ) ' => ['request' => $this->lastNmKanaCase1(), 'expect' => false], 
            'エラー(未入力)性別' => ['request' => $this->sexCase1(), 'expect' => false], 
            'エラー(未入力)誕生日(年)' => ['request' => $this->birthdayYearCase1(), 'expect' => false], 
            'エラー(未入力)誕生日(月)' => ['request' => $this->birthdayMonthCase1(), 'expect' => false], 
            'エラー(未入力)誕生日(日)' => ['request' => $this->birthdayDayCase1(), 'expect' => false], 
            'エラー(未入力)郵便番号' => ['request' => $this->postCdCase1(), 'expect' => false], 
            'エラー(未入力)都道府県' => ['request' => $this->prefecturesCdCase1(), 'expect' => false], 
            'エラー(未入力)住所1' => ['request' => $this->address1Case1(), 'expect' => false], 
            'エラー(文字数オーバー)住所2' => ['request' => $this->address2Case1(), 'expect' => false], 
            'エラー(未入力)携帯番号' => ['request' => $this->telKeitaiCase1(), 'expect' => false], 
            'エラー(未入力)自宅番号' => ['request' => $this->telZitakuCase1(), 'expect' => false], 
            'エラー(文字数オーバー)希望' => ['request' => $this->hopeCase1(), 'expect' => false], 
            'エラー(文字数オーバー)メールアドレス' => ['request' => $this->emailCase1(), 'expect' => false], 
            'エラー(文字数オーバー)メールアドレス(確認)}' => ['request' => $this->emailConfirmCase1(), 'expect' => false], 
        ];
    }
    
   // ベースデータ
   private function baseInputData(){
       $repository = new \App\Repositories\Content\ReceptionRepository();
       $service = new \App\Services\Content\ReceptionService($repository);
       $inputData = $service->getInputData();
       
       $inputData['reception']['kyogi_id'] = 1;
       $inputData['reception']['kyogi_hope_date'] = '2021-10-23';
       $inputData['reception']['raizyo'] = Consts::move['公共交通機関'];
       $inputData['reception']['raizyo_number_plate'] = '11-22';
       $inputData['reception']['raizyo_kotukikan'] = Consts::koutukikan['路線バス'];
       $inputData['reception']['taizyo'] = Consts::move['公共交通機関'];
       $inputData['reception']['taizyo_number_plate'] = '11-22';
       $inputData['reception']['taizyo_kotukikan'] = Consts::koutukikan['路線バス'];
       $inputData['reception_members'][0]['first_nm'] = '山田';
       $inputData['reception_members'][0]['last_nm'] = '太郎';
       $inputData['reception_members'][0]['first_nm_kana'] = 'ヤマダ';
       $inputData['reception_members'][0]['last_nm_kana'] = 'タロウ';
       $inputData['reception_members'][0]['sex'] = Consts::sex['男'];
       $inputData['reception_members'][0]['birthday_year'] = '1993';
       $inputData['reception_members'][0]['birthday_month'] = '3';
       $inputData['reception_members'][0]['birthday_day'] = '21';
       $inputData['reception_members'][0]['post_cd'] = '480-0101';
       $inputData['reception_members'][0]['prefectures_cd'] = Consts::prefectures['愛知県'];
       $inputData['reception_members'][0]['address1'] = '丹羽郡扶桑町山那';
       $inputData['reception_members'][0]['address2'] = '110番地';
       $inputData['reception_members'][0]['tel_keitai'] = '09099990888';
       $inputData['reception_members'][0]['tel_zitaku'] = '0587932990';
       $inputData['reception_members'][0]['hope'] = '希望内容1';
       $inputData['reception_members'][0]['email'] = 'homing0321r4cfw@yahoo.co.jp';
       $inputData['reception_members'][0]['email_confirm'] = 'homing0321r4cfw@yahoo.co.jp';
       
       unset($inputData['reception_members'][1]);
       unset($inputData['reception_members'][2]);
       unset($inputData['reception_members'][3]);
       return $inputData;
   }
   
   // 競技名(未入力)
   private function kyogiIdCase1(){
       $data = $this->baseInputData();
       $data['reception']['kyogi_id'] = '';
       return $data;
   }
   
   // 競技希望日(未入力)
   private function kyogiHopeDateCase1(){
       $data = $this->baseInputData();
       $data['reception']['kyogi_hope_date'] = '';
       return $data;
   }
   
   // 移動方法(開会式)未入力
   private function raizyoMoveCase1(){
       $data = $this->baseInputData();
       $data['reception']['raizyo'] = '';
       return $data;
   }
   
   // ナンバープレート(開会式)桁数オーバー
   private function raizyoNumberPlateCase1(){
       $data = $this->baseInputData();
       $data['reception']['raizyo_number_plate'] = '01234567890123456789001234567890123456789012345678901';
       return $data;
   }
   
   // 公共交通機関(開会式)桁数オーバー
   private function raizyoKotukikanCase1(){
       $data = $this->baseInputData();
       $data['reception']['raizyo_kotukikan'] = '22';
       return $data;
   }
   
   // 移動方法(閉会式)未入力
   private function taizyoMoveCase1(){
       $data = $this->baseInputData();
       $data['reception']['taizyo'] = '';
       return $data;
   }
   
   // ナンバープレート(閉会式)桁数オーバー
   private function taizyoNumberPlateCase1(){
       $data = $this->baseInputData();
       $data['reception']['taizyo_number_plate'] = '01234567890123456789001234567890123456789012345678901';
       return $data;
   }
   
   // 公共交通機関(閉会式)桁数オーバー
   private function taizyoKotukikanCase1(){
       $data = $this->baseInputData();
       $data['reception']['taizyo_kotukikan'] = '22';
       return $data;
   }
   
   // 姓 未入力
   private function firstNmCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['first_nm'] = '';
       return $data;
   }
   
   // 名 未入力
   private function lastNmCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['last_nm'] = '';
       return $data;
   }
   
   // 姓(カナ) 全角ひらがな入力
   private function firstNmKanaCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['first_nm_kana'] = '';
       return $data;
   }
   
   // 名(カナ) 全角ひらがな入力
   private function lastNmKanaCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['last_nm_kana'] = '';
       return $data;
   }
   
   // 性 未入力
   private function sexCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['sex'] = '';
       return $data;
   }
   
   // 誕生日(年) 未入力
   private function birthdayYearCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['birthday_year'] = '';
       return $data;
   }
   
   // 誕生日(年) 未入力
   private function birthdayMonthCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['birthday_month'] = '';
       return $data;
   }
   
   // 誕生日(年) 未入力
   private function birthdayDayCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['birthday_day'] = '';
       return $data;
   }
   
   // 郵便番号 未入力
   private function postCdCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['post_cd'] = '';
       return $data;
   }
   
   // 都道府県 未入力
   private function prefecturesCdCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['prefectures_cd'] = '';
       return $data;
   }
   
   // 住所1 未入力
   private function address1Case1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['address1'] = '';
       return $data;
   }
   
   // 住所2 文字数オーバー
   private function address2Case1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['address2'] = '01234567890123456789012345678901234567890';
       return $data;
   }
   
   // 携帯番号 未入力
   private function telKeitaiCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['tel_keitai'] = '';
       return $data;
   }
   
   // 自宅番号 未入力
   private function telZitakuCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['tel_zitaku'] = '';
       return $data;
   }
   
   // 希望 文字数オーバー
   private function hopeCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['hope'] = '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890';
       return $data;
   }
   
   // メールアドレス 文字数オーバー
   private function emailCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['email'] = '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234';
       return $data;
   }
   
   // メールアドレス(確認) 文字数オーバー
   private function emailConfirmCase1(){
       $data = $this->baseInputData();
       $data['reception_members'][0]['email_confirm'] = '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234';
       return $data;
   }
}
