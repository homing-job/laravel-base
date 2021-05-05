<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Kyogi
 *
 * @property object $receptions
 * @property object $kyogiPlans
 */
class Kyogi extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = ['id', 'updated_at', 'created_at', 'deleted_at']; // ブラックリスト

    // リレーション(子)
    public function kyogiPlans(){
        return $this->hasMany('App\Models\KyogiPlan');
    }
    
    // リレーション(子)
    public function receptions(){
        return $this->hasMany('App\Models\Reception');
    }
}
