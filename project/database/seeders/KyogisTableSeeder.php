<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KyogisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kyogis')->insert(['kyogi_nm' => '陸上競技', 'address' => '伊勢市', 'kaizyo_nm' => '名古屋市体育館 1F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => '水泳', 'address' => '鈴鹿市', 'kaizyo_nm' => '名古屋市体育館 1F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'アーチェリー', 'address' => '松阪市', 'kaizyo_nm' => '名古屋市体育館 1F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => '卓球', 'address' => '伊勢市', 'kaizyo_nm' => '名古屋市体育館 2F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'フライングディスク', 'address' => '東員町', 'kaizyo_nm' => '名古屋市体育館 2F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'ボウリング', 'address' => '津市', 'kaizyo_nm' => '名古屋市体育館 2F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'ボッチャ', 'address' => '伊勢市', 'kaizyo_nm' => '名古屋市体育館 3F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'バスケットボール', 'address' => '津市', 'kaizyo_nm' => '名古屋市体育館 3F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => '車いすバスケットボール', 'address' => '津市', 'kaizyo_nm' => '名古屋市体育館 3F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'ソフトボール', 'address' => '紀北町', 'kaizyo_nm' => '北名古屋市体育館 1F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'グランドソフトボール', 'address' => '明和町', 'kaizyo_nm' => '北名古屋市体育館 1F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'バレーボール', 'address' => '四日市市', 'kaizyo_nm' => '北名古屋市体育館 1F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => '野球', 'address' => '津市', 'kaizyo_nm' => '北名古屋市体育館 2F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'サッカー', 'address' => '鈴鹿市', 'kaizyo_nm' => '北名古屋市体育館 2F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'フットベースボール', 'address' => '志摩市', 'kaizyo_nm' => '北名古屋市体育館 2F',]);
        DB::table('kyogis')->insert(['kyogi_nm' => 'ドッチボール', 'address' => '志摩市', 'kaizyo_nm' => '北名古屋市体育館 2F',]);
    }
}
