<?php

namespace App\Repositories\Content;

use App\Models\Kyogi;
use App\Models\Reception;
use App\Models\ReceptionMember;
use Illuminate\Database\Eloquent\Collection;

/**
 * リポジトリクラス
 *
 */
class ConfirmationRepository {
    // 競技データ取得
    public function getKyogi(string $kyogi_id): Kyogi{
        return Kyogi::find($kyogi_id);
    }
    
    // 申込データ読込
    public function getReception(string $reception_id) : Reception{
        return Reception::with(['receptionMembers'])
                            ->where('id', $reception_id)
                            ->first();
    }
    
    // 申込作業者データ読込
    public function getReceptionMembers(string $reception_id) : Collection{
        return ReceptionMember::where('reception_id', $reception_id)
                                ->orderBy('sort_no')
                                ->get();
    }
    
    // 申込 登録
    public function createReception(array $reception) : object{
        return Reception::create($reception);
    }
    
    // 申込 登録
    public function createReceptionMember(array $reception_member) : void{
        ReceptionMember::create($reception_member);
    }
}
