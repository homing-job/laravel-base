<?php

namespace App\Repositories\Content;

use App\Models\Kyogi;
use App\Models\Reception;
use Illuminate\Database\Eloquent\Collection;

/**
 * インターフェース
 *
 */
interface ConfirmationRepositoryInterface {
    // 競技データ取得
    public function getKyogi(string $kyogi_id): Kyogi;
    // 申込データ読込
    public function getReception(string $reception_id): Reception;
    // 申込作業者データ読込
    public function getReceptionMembers(string $reception_id): Collection;
    // 申込 登録
    public function createReception(array $reception);
    // 申込作業者 登録
    public function createReceptionMember(array $reception_member);
}