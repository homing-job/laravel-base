<?php

namespace App\Repositories\Admin;

use App\Models\KyogiPlan;
use App\Models\Reception;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\ReceptionStatusListRequest;
use Illuminate\Database\Eloquent\Collection;

/**
 * リポジトリクラス
 *
 */
class ReceptionStatusRepository {
    // 一覧取得
    public function getList(ReceptionStatusListRequest $request): Collection{
        return  Reception::join('kyogis', 'receptions.kyogi_id','=','kyogis.id')
                          ->join('reception_members', function ($query) {
                             $query->on('receptions.id', '=', 'reception_members.reception_id')
                                 ->where('reception_members.is_daihyo', '=', true);
                          })
                          ->select(DB::raw('receptions.id'
                                        . ', receptions.created_at'
                                        . ', receptions.reception_no'
                                        . ', kyogis.kyogi_nm'
                                        . ', receptions.kyogi_hope_date'
                                        . ', CONCAT(reception_members.first_nm, reception_members.last_nm) as daihyo_full_nm'
                                        . ', reception_members.tel_keitai'
                                        . ', reception_members.tel_zitaku'))
                          ->where($request->filters())
                          ->orderByDesc('reception_members.created_at')
                          ->orderBy('kyogis.kaizyo_nm')
                          ->orderBy('receptions.kyogi_hope_date')
                          ->get();
    }
    
    // 削除
    public function delete(string $id): void{
        Reception::where('id', $id)->first()->delete();
    }
}
