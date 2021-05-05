<?php

namespace App\Repositories\Admin;

use App\Models\KyogiPlan;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Admin\ReceptionStatusListRequest;

/**
 * インターフェース
 *
 */
interface ReceptionStatusRepositoryInterface {
    // 一覧取得
    public function getList(ReceptionStatusListRequest $request): Collection;
    // 削除
    public function delete(string $id): void;
    // １件取得
    public function getOne(string $id): KyogiPlan;
}