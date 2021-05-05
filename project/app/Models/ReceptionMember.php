<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class ReceptionMember extends Model
{
    use SoftDeletes; // 論理削除トレイト

    protected $guarded = ['id', 'updated_at', 'created_at', 'deleted_at']; // ブラックリスト

    // リレーション(親)
    public function reception()
    {
        return $this->belongsTo('App\Models\Reception');
    }
}
