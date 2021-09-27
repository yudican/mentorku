<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaction_total_price')->nullable();
            $table->integer('transaction_unique_id')->nullable();
            $table->dateTime('transaction_date')->nullable();
            $table->dateTime('transaction_expired_date')->nullable();
            $table->string('transaction_struct_upload')->nullable();
            $table->text('transaction_note')->nullable();
            $table->char('transaction_status', 1)->nullable()->default(0)->comment('0=waiting payment,1=on progress;2=success;3=decline;4=expired');

            $table->foreignId('bank_id');
            $table->foreignId('plan_id');
            $table->foreignUuid('user_id');
            $table->timestamps();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
}
