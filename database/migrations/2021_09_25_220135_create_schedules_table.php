<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->text('schedule_topic')->nullable();
            $table->dateTime('schedule_date')->nullable();
            $table->integer('schedule_duration')->nullable();
            $table->string('schedule_link_meet')->nullable();
            $table->text('schedule_note')->nullable();
            $table->char('schedule_status', 1)->nullable()->default(0)->comment('0=waiting,1=approve,2=decline,3=cancel,4=non active');

            $table->foreignId('mentor_id');
            $table->foreignUuid('user_id');
            $table->timestamps();
            $table->foreign('mentor_id')->references('id')->on('mentors')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
