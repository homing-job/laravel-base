<?php

namespace App\Services\Content;

use App\Libs\Utility;
use App\Libs\Consts;
use App\Libs\Session;
use App\Repositories\Content\ReceptionRepository;

/**
 * サービスクラス
 *
 */
class ReceptionService {
    private $repository;
    public function __construct(ReceptionRepository $repository){
        $this->repository = $repository;
    }
    
    // 入力申込内容セット
    public function setInputData($request){
        $request->session()->put(Session::RECEPTION_INPUT_DATA, $request->all());
    }
    
    // 競技データ取得
    public function getKyogis(){
        return $this->repository->getKyogis()->toArray();
    }
    
    // 競技名称一覧取得
    public function getKyogiNms(){
        return $this->repository->getKyogiNms()->pluck('kyogi_nm','id');
    }
    
    /**
     * 入力用データ取得(入力履歴sessionが存在する場合は履歴を使用)
     *
     * @return array
     */
    public function getInputData($isReset=false) :array
    {
        $reception = array();
        $reception_members = array();
        if($isReset || !session()->exists(Session::RECEPTION_INPUT_DATA)){
            // 初期化
            $reception = $this->defaultReception();
            $reception_members = [$this->defaultReceptionMember(true, 1)
                                , $this->defaultReceptionMember(false, 2)
                                , $this->defaultReceptionMember(false, 3)
                                , $this->defaultReceptionMember(false, 4)];
        }else{
            // 入力履歴sessionから読込
            $session = session()->get(Session::RECEPTION_INPUT_DATA);
            $reception = $session['reception'];
            for ($sort_no = 1; $sort_no <= 4; $sort_no++){
                $history_member = collect($session['reception_members'])->firstWhere('sort_no', $sort_no);
                if(!empty($history_member)){
                    $reception_members[] = $history_member;
                }else{
                    $reception_members[] = $this->defaultReceptionMember(false, $sort_no);
                }
            }
        }
        return ['reception' => $reception, 'reception_members' => $reception_members];
    }

    // reception初期値
    private function defaultReception() :array
    {
        $reception = Utility::getEmptyTableColumns('receptions', 1);
        $reception['sogou_taizyo'] = Consts::move['公共交通機関'];
        $reception['raizyo'] = Consts::move['公共交通機関'];
        $reception['taizyo'] = Consts::move['公共交通機関'];
        return $reception;
    }

    // reception_member初期値
    private function defaultReceptionMember(bool $isDaihyo, int $sort_no) :array
    {
        $reception_member = Utility::getEmptyTableColumns('reception_members', 1);
        if(!$isDaihyo) {
            $reception_member['is_daihyo'] = false;
            $reception_member['is_disp'] = false; // 登録時に消す
        }else{
            $reception_member['is_daihyo'] = true;
            $reception_member['is_disp'] = true; // 登録時に消す
        }
        $reception_member['sex'] = Consts::sex['男'];
        $reception_member['email_confirm'] = ''; // 登録時に消す
        $reception_member['sort_no'] = $sort_no;
        return $reception_member;
    }
}
