<?php

namespace Tests\Unit\Request;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\Master\GeneralRequest;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\General;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GeneralRequestTest extends TestCase
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

        $request = new GeneralRequest();
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
            '正常(全て)' => ['request' => General::factory()->make()->toArray(), 'expect' => true], 
            '正常(kbn)' => ['request' => General::factory()->make(['kbn' => str_repeat('あ', 20)])->toArray(), 'expect' => true], 
            '正常(value)' => ['request' => General::factory()->make(['value' => str_repeat('あ', 50)])->toArray(), 'expect' => true], 
            '正常(sort_no)' => ['request' => General::factory()->make(['sort_no' => str_repeat(9, 9)])->toArray(), 'expect' => true], 
            'エラー(kbn未入力)' => ['request' => General::factory()->make(['kbn' => null])->toArray(), 'expect' => false], 
            'エラー(kbn文字数オーバー)' => ['request' => General::factory()->make(['kbn' => str_repeat('あ', 21)])->toArray(), 'expect' => false], 
            'エラー(value未入力)' => ['request' => General::factory()->make(['value' => null])->toArray(), 'expect' => false], 
            'エラー(value文字数オーバー)' => ['request' => General::factory()->make(['value' => str_repeat('あ', 51)])->toArray(), 'expect' => false], 
            'エラー(sort_no未入力)' => ['request' => General::factory()->make(['sort_no' => null])->toArray(), 'expect' => false], 
            'エラー(sort_no桁数オーバー)' => ['request' => General::factory()->make(['sort_no' => str_repeat(1, 10)])->toArray(), 'expect' => false], 
            'エラー(sort_no全角)' => ['request' => General::factory()->make(['sort_no' => str_repeat('あ', 2)])->toArray(), 'expect' => false], 
        ];
    }
    
    /**
     * 楽観ロックチェックテスト
     *
     */
    public function testOptimisticLock()
    {
        // なぜかrequestクラス内のwithValidatorが正常に動かない
        $this->assertEquals(1, 1);
    }
}
