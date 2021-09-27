<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_plans', function (Blueprint $table) {
            $table->id();
            $table->dateTime('plan_start_date')->nullable();
            $table->dateTime('plan_end_date')->nullable();
            $table->char('plan_status', 1)->nullable()->default(0)->comment('0=active,2=expired,3=suspend');

            $table->foreignId('plan_id');
            $table->foreignUuid('user_id');
            $table->timestamps();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
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
        Schema::dropIfExists('active_plans');
    }
}
