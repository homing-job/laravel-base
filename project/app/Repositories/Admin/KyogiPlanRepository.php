<?php

namespace App\Repositories\Admin;

use App\Models\KyogiPlan;
use App\Http\Requests\Admin\KyogiPlanListRequest;
use App\Http\Requests\Admin\KyogiPlanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * リポジトリクラス
 *
 */
class KyogiPlanRepository {
    // 一覧取得
    public function getList(KyogiPlanListRequest $request): Collection{
        return KyogiPlan::join('kyogis', 'kyogi_plans.kyogi_id','=','kyogis.id')
                            ->select(DB::raw('kyogi_plans.id, kyogis.kyogi_nm, kyogis.kaizyo_nm, kyogi_plans.kyogi_date'))
                            ->where($request->filters())
                            ->orderBy('kaizyo_nm')
                            ->orderBy('kyogi_date')
                            ->get();
    }
    
    // 登録
    public function create(KyogiPlanRequest $request): void{
        KyogiPlan::create($request->all());
    }
    
    // 削除
    public function delete($id): void{
        KyogiPlan::where('id', $id)->delete();
    }
    
    // １件取得
    public function find($id): KyogiPlan{
        return KyogiPlan::find($id);
    }
}
