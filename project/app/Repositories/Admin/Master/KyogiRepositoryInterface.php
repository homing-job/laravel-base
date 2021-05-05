<?php

namespace App\Repositories\Admin\Master;

use Illuminate\Http\Request;
use App\Models\Kyogi;
use App\Http\Requests\Admin\Master\KyogiListRequest;
use App\Http\Requests\Admin\Master\KyogiRequest;
use Illuminate\Database\Eloquent\Collection;

/**
 * インターフェース
 *
 */
interface KyogiRepositoryInterface {
    // 一覧取得
    public function getList(KyogiListRequest $request): Collection;
    // 登録
    public function create(KyogiRequest $request): void;
    // 削除
    public function delete(string $id): void;
    // 更新
    public function update(KyogiRequest $request, string $id): void;
    // １件取得
    public function getOne(string $id): Kyogi;
}