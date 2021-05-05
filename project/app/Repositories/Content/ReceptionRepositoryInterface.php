<?php

namespace App\Repositories\Content;

use Illuminate\Database\Eloquent\Collection;

/**
 * インターフェース
 *
 */
interface ReceptionRepositoryInterface {
    // 競技データ取得
    public function getKyogis(): Collection;
    // 競技名称一覧取得
    public function getKyogiNms(): Collection;
}