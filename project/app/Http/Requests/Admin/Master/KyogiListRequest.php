<?php

namespace App\Http\Requests\Admin\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Constant\Session;

class KyogiListRequest extends FormRequest
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
            'kyogi_nm' => 'nullable',
            'kaizyo_nm' => 'nullable',
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
            'kaizyo_nm' => '会場名',
        ];
    }
    
    /**
     * 抽出条件
     *
     * @return array
     */
    public function filters(): array{
        $filters = [];
        if(isset($this->kyogi_nm)) {
            $filters[] = ['kyogi_nm', 'LIKE', '%'. $this->kyogi_nm. '%'];
        }
        if(isset($this->kaizyo_nm)) {
            $filters[] = ['kaizyo_nm', 'LIKE', '%'. $this->kaizyo_nm. '%'];
        }
        return $filters;  
    }
    
    /**
     * 条件記憶用セッションセット
     *
     * @param  KyogiListRequest $request
     * @return void
     */
    public static function setRequestSession(KyogiListRequest $request){
        $request->session()->put(Session::KYOGI_LIST_CONDS, $request->all());
    }
    
    /**
     * 条件記憶用セッション取得
     *
     * @param  Request $request
     * @return array
     */
    public static function getRequestSession(Request $request) : array{
        $conds = [];
        if($request->isInit){
            $request->session()->forget(Session::KYOGI_LIST_CONDS);
        }else{
            $session_val = $request->session()->get(Session::KYOGI_LIST_CONDS);
            $conds = $session_val ? $session_val : [];
        }
        return $conds;
    }
}
