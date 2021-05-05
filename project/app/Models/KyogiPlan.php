<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class KyogiPlan extends Model
{
    use SoftDeletes; // 論理削除トレイト

    protected $guarded = ['id', 'updated_at', 'created_at', 'deleted_at']; // ブラックリスト

    // リレーション(親)
    public function kyogi()
    {
        return $this->belongsTo('App\Models\Kyogi');
    }

    // 競技日一覧
    public static function getKyogiDates() {
        $kyogiDates = array();
        $dates = self::groupBy('kyogi_date')->orderBy('kyogi_date')->pluck('kyogi_date','kyogi_date');
        foreach ($dates as $date){
            $kyogiDates[$date] = Carbon::parse($date)->isoFormat('MM月DD日(ddd)');;
        }
        return $kyogiDates;
    }
}
