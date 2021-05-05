<?php

namespace App\Repositories\Content;

use App\Models\Kyogi;
use Illuminate\Database\Eloquent\Collection;

/**
 * リポジトリクラス
 *
 */
class ReceptionRepository{
    // 競技データ取得
    public function getKyogis(): Collection{
        return Kyogi::with('kyogiPlans')->get();
    }
    
    // 競技名称一覧取得
    public function getKyogiNms(): Collection{
        return Kyogi::orderBy('kyogi_nm')->get();
    }
}
