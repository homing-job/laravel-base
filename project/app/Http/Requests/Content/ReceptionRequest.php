<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use App\Models\KyogiPlan;
use App\Libs\Consts;

class ReceptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'reception.kyogi_id' => 'required|integer',
            'reception.kyogi_hope_date' => 'required|date',
            'reception.raizyo' => 'required|integer|digits_between:1,1',
            'reception.raizyo_number_plate' => 'nullable|string|max:50',
            'reception.raizyo_kotukikan' => 'nullable|integer|digits_between:1,1',
            
            'reception.taizyo' => 'required|integer|digits_between:1,1',
            'reception.taizyo_number_plate' => 'nullable|string|max:50',
            'reception.taizyo_kotukikan' => 'nullable|integer|digits_between:1,1',

            'reception_members.*.first_nm' => 'required|string|max:20',
            'reception_members.*.last_nm' => 'required|string|max:20',
            'reception_members.*.first_nm_kana' => ['required', 'string', 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u', 'max:20'],
            'reception_members.*.last_nm_kana' => ['required', 'string', 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u', 'max:20'],
            'reception_members.*.sex' => 'required|integer|digits_between:1,1',
            'reception_members.*.birthday_year' => 'required|integer|digits_between:1,4',
            'reception_members.*.birthday_month' => 'required|integer|digits_between:1,2',
            'reception_members.*.birthday_day' => 'required|integer|digits_between:1,2',
            'reception_members.*.post_cd' => 'required|string',
            'reception_members.*.prefectures_cd' => 'required|string|digits:2',
            'reception_members.*.address1' => 'required|string|max:40',
            'reception_members.*.address2' => 'nullable|string|max:40',
            'reception_members.*.tel_keitai' => 'required|string|max:13',
            'reception_members.*.tel_zitaku' => 'required|string|max:13',
            'reception_members.*.hope' => 'nullable|string|max:500',
            'reception_members.*.email' => 'nullable|string|max:254',
            'reception_members.*.email_confirm' => 'nullable|string|max:254',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes() {
        return [
            'reception.kyogi_id' => '競技名',
            'reception.kyogi_hope_date' => '希望日',
            'reception.raizyo' => '開会式',
            'reception.raizyo_number_plate' => 'ナンバープレート',
            'reception.raizyo_kotukikan' => '公共交通機関',
            'reception.taizyo' => '閉会式',
            'reception.taizyo_number_plate' => 'ナンバープレート',
            'reception.taizyo_kotukikan' => '公共交通機関',

            'reception_members.*.first_nm' =>  '姓',
            'reception_members.*.last_nm' =>  '名',
            'reception_members.*.first_nm_kana' =>  'セイ',
            'reception_members.*.last_nm_kana' =>  'メイ',
            'reception_members.*.sex' =>  '性別',
            'reception_members.*.birthday_year' =>  '年',
            'reception_members.*.birthday_month' =>  '月',
            'reception_members.*.birthday_day' =>  '日',
            'reception_members.*.post_cd' =>  '郵便番号',
            'reception_members.*.prefectures_cd' =>  '住所1',
            'reception_members.*.address1' =>  '住所2',
            'reception_members.*.address2' =>  '住所3',
            'reception_members.*.tel_keitai' =>  '携帯電話番号',
            'reception_members.*.tel_zitaku' =>  '自宅電話番号',
            'reception_members.*.hope' =>  '配席要望',
            'reception_members.*.email' =>  'メールアドレス',
            'reception_members.*.email_confirm' =>  'メールアドレス(確認)',
        ];
    }

    /**
     * 特殊なバリデーションを行う場合はここに処理を記述する
     *
     * @return void
     */
    public function withValidator(Validator $validator) {
        /* ここにバリデーションを書く */
        $validator->after(function ($validator) {
            // <editor-fold desc="reception 処理">
            // 存在しない観覧希望日を選択した場合
            $kyogi_id = $this->input('reception.kyogi_id');
            $kyogi_hope_date = $this->input('reception.kyogi_hope_date');
            if(!empty($kyogi_id)){
                $check = KyogiPlan::where('kyogi_id', $kyogi_id)
                                        ->where('kyogi_date', $kyogi_hope_date)
                                        ->exists();
                if(!$check) $validator->errors()->add('reception.kyogi_date', '正しい観覧希望日を選択して下さい。');
            }
            
            // 閉会式:自家用車の場合は、ナンバープレートの入力必須
            $raizyo = $this->input('reception.raizyo');
            $raizyo_number_plate = $this->input('reception.raizyo_number_plate');
            if($raizyo == Consts::move['自家用車']){
                if(empty($raizyo_number_plate)) $validator->errors()->add('reception.raizyo_number_plate', 'ナンバープレートを入力して下さい。');
            }
            // 開会式:公共交通期間の場合は、公共交通期間の選択必須
            $raizyo_kotukikan = $this->input('reception.raizyo_kotukikan');
            if($raizyo == Consts::move['公共交通機関']){
                if(empty($raizyo_kotukikan)) $validator->errors()->add('reception.raizyo_kotukikan', '公共交通機関を選択して下さい。');
            }

            // 閉会式:自家用車の場合は、ナンバープレートの入力必須
            $taizyo = $this->input('reception.taizyo');
            $taizyo_number_plate = $this->input('reception.taizyo_number_plate');
            if($taizyo == Consts::move['自家用車']){
                if(empty($taizyo_number_plate)) $validator->errors()->add('reception.taizyo_number_plate', 'ナンバープレートを入力して下さい。');
            }
            // 閉会式:公共交通期間の場合は、公共交通期間の選択必須
            $taizyo_kotukikan = $this->input('reception.taizyo_kotukikan');
            if($taizyo == Consts::move['公共交通機関']){
                if(empty($taizyo_kotukikan)) $validator->errors()->add('reception.taizyo_kotukikan', '公共交通機関を選択して下さい。');
            }
            // </editor-fold>

            // <editor-fold desc="reception_members 処理">
            $reception_members = $this->input('reception_members');
            foreach($reception_members as $key => $reception_member){
                if(!$reception_member['is_daihyo']) continue;
                $target = 'reception_members.'. $key. '.';
                // 確認メールアドレス相違
                if($reception_member['email'] != $reception_member['email_confirm']){
                    $validator->errors()->add($target. 'email', 'メールアドレスを確認して下さい。');
                    $validator->errors()->add($target. 'email_confirm', 'メールアドレスを確認して下さい。');
                }
                // メールアドレス未入力
                if(!$reception_member['email']){
                    $validator->errors()->add($target. 'email', 'メールアドレスを入力下さい。');
                }
                if(!$reception_member['email_confirm']){
                    $validator->errors()->add($target. 'email_confirm', '確認メールアドレスを入力下さい。');
                }
            }


            // </editor-fold>
        });
    }

    /**
     * バリデーションエラー後の処理を変える場合はここに処理を記述する
     * デフォルトはリダイレクト
     *
     * @return array
     */
    protected function failedValidation(Validator $validator) {
        $response = response()->json([
            'status' => 400,
            'errors' => $validator->errors(),
        ], 400);
        throw new HttpResponseException($response);
    }
}
