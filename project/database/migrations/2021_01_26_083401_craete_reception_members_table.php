<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CraeteReceptionMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reception_members', function (Blueprint $table) {
            $table->id();
            $table->integer('reception_id')->unsigned();
            $table->string('first_nm');
            $table->string('last_nm');
            $table->string('first_nm_kana');
            $table->string('last_nm_kana');
            $table->string('sex');
            $table->integer('birthday_year')->unsigned();
            $table->integer('birthday_month')->unsigned();
            $table->integer('birthday_day')->unsigned();
            $table->string('post_cd');
            $table->string('prefectures_cd');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('tel_keitai');
            $table->string('tel_zitaku');
            $table->text('hope')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_daihyo');
            $table->integer('sort_no')->unsigned();
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reception_members');
    }
}
