<?php

namespace App\Services\Content;

use App\Libs\Session;
use App\Models\General;
use Illuminate\Support\Facades\DB;
use App\Repositories\Content\ConfirmationRepository;

/**
 * サービスクラス
 *
 */
class ConfirmationService {
    private $repository;
    public function __construct(ConfirmationRepository $repository){
        $this->repository = $repository;
    }
    
    // 入力申込内容取得
    public function getInputReception(){
        return session()->get(Session::RECEPTION_INPUT_DATA);
    }
    
    // 競技データ取得
    public function getKyogi($kyogi_id){
        return $this->repository->getKyogi($kyogi_id);
    }
    
    // 申込データ読込
    public function getReception($reception_id){
        return ['reception' => $this->repository->getReception($reception_id)->toArray()
                , 'reception_members' => $this->repository->getReceptionMembers($reception_id)->toArray()];
    }
    
    // 登録
    public function create(){
        DB::transaction(function () {
            $input_data = $this->getInputReception();
            // receptions 登録
            $reception = $input_data['reception'];
            $reception['reception_no'] = General::getSequence('受付番号(シーケンス番号)');
            $create_reception = $this->repository->createReception($reception);
            $reception_id = $create_reception->id;
            // reception_members 登録
            array_map(function($reception_member) use($reception_id){
                $reception_member['reception_id'] = $reception_id;
                unset($reception_member['email_confirm']);
                unset($reception_member['is_disp']);
                $this->repository->createReceptionMember($reception_member);
            }, $input_data['reception_members']);
            
            // シーケンス番号更新
            General::sequenceUpdate('受付番号(シーケンス番号)');
            
            // 入力セッション削除
            session()->forget(Session::RECEPTION_INPUT_DATA);
        });
    }
}
