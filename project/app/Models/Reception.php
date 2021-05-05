<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Reception extends Model
{
    use SoftDeletes; // 論理削除トレイト

    protected $guarded = ['id', 'updated_at', 'created_at', 'deleted_at']; // ブラックリスト

    // リレーション(子)
    public function receptionMembers(){
        return $this->hasMany('App\Models\ReceptionMember');
    }
    
    // リレーション(代表)
    public function receptionMembers_daihyo(){
        return $this->hasOne('App\Models\Kyogi')->where('is_daihyo')->first();
    }

    // リレーション(子)
    public function kyogi(){
        return $this->hasOne('App\Models\Kyogi');
    }
    
    // イベント割り当て
    protected static function boot(){
        parent::boot();
        // 削除時に子テーブルを削除する
        static::deleting(function($model) {
            $model->receptionMembers()->delete();
        });
    }
}
