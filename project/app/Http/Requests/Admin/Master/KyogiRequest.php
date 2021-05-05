<?php

namespace App\Http\Requests\Admin\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Kyogi;
use Illuminate\Support\Facades\Log;

class KyogiRequest extends FormRequest
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
            'kyogi_nm' => 'required|max:20',
            'address' => 'required|max:50',
            'kaizyo_nm' => 'required|max:50',
            'updated_at' => 'date|nullable',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes() {
        return [
            'kyogi_nm' => '競技名',
            'address' => '住所',
            'kaizyo_nm' => '会場名',
            'updated_at' => '更新日時',
        ];
    }
    
    /**
     * 特殊なバリデーションを行う場合はここに処理を記述する
     *
     * @return void
     */
    public function withValidator($validator) {
        /* ここにバリデーションを書く */
        $validator->after(function ($validator) {
            if(!empty($this->input('id'))
                    && Kyogi::find($this->input('id'))->updated_at > $this->input('updated_at')){
                $validator->errors()->add('updated_at', 'すでに変更されたデータの可能性があります。最新の状態で再度実行してください。');
            }
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
