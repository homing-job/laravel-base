<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Constant\Session;

class ReceptionStatusListRequest extends FormRequest
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
            'kyogi_hope_date' => 'nullable',
            'tel_keitai' => 'nullable',
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
            'kyogi_hope_date' => '希望日',
            'tel_keitai' => '形態番号',
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
        if(isset($this->kyogi_hope_date)) {
            $filters[] = ['kyogi_hope_date', 'LIKE', '%'. $this->kyogi_hope_date. '%'];
        }
        if(isset($this->tel_keitai)) {
            $filters[] = ['tel_keitai', 'LIKE', '%'. $this->tel_keitai. '%'];
        }
        return $filters;  
    }
    
    /**
     * 条件記憶用セッションセット
     *
     * @param  ReceptionStatusListRequest $request
     * @return void
     */
    public static function setRequestSession(ReceptionStatusListRequest $request){
        $request->session()->put(Session::RECEPTION_STATUS_LIST_CONDS, $request->all());
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
            $request->session()->forget(Session::RECEPTION_STATUS_LIST_CONDS);
        }else{
            $session_val = $request->session()->get(Session::RECEPTION_STATUS_LIST_CONDS);
            $conds = $session_val ? $session_val : [];
        }
        return $conds;
    }
}
