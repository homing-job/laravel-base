<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CraeteReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptions', function (Blueprint $table) {
            $table->id();
            $table->integer('reception_no')->unsigned();
            $table->integer('kyogi_id');
            $table->date('kyogi_hope_date');
            $table->string('raizyo');
            $table->string('raizyo_number_plate')->nullable();
            $table->string('raizyo_kotukikan')->nullable();
            $table->string('taizyo');
            $table->string('taizyo_number_plate')->nullable();
            $table->string('taizyo_kotukikan')->nullable();
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
        Schema::dropIfExists('receptions');
    }
}
