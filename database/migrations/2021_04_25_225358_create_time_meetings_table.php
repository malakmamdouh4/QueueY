<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('time');
            $table->integer('active')->default(0)->nullable();
            $table->unsignedBigInteger('day_meeting_id');
            $table->foreign('day_meeting_id')->references('id')->on('day_meetings');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_meetings');
    }
}
