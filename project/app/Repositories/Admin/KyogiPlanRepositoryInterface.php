<?php

namespace App\Repositories\Admin;

use App\Models\KyogiPlan;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Admin\KyogiPlanListRequest;
use App\Http\Requests\Admin\KyogiPlanRequest;

/**
 * インターフェース
 *
 */
interface KyogiPlanRepositoryInterface {
    // 一覧取得
    public function getList(KyogiPlanListRequest $request): Collection;
    // 登録
    public function create(KyogiPlanRequest $request): void;
    // 削除
    public function delete(string $id): void;
    // １件取得
    public function getOne(string $id): KyogiPlan;
}