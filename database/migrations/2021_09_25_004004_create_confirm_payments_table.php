<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_payments', function (Blueprint $table) {
            $table->id();
            $table->string('confirm_bank_name')->nullable();
            $table->string('confirm_bank_account_name')->nullable();
            $table->string('confirm_bank_account_number')->nullable();
            $table->string('confirm_amount')->nullable();
            $table->string('confirm_photo')->nullable();
            $table->dateTime('confirm_date')->nullable();
            $table->text('confirm_note')->nullable();
            $table->char('confirm_status', 1)->nullable()->default(0)->comment('0=waiting payment,1=on progress;2=success;3=decline;4=expired');

            $table->foreignUuid('transaction_id');
            $table->foreignUuid('user_id');
            $table->timestamps();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
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
        Schema::dropIfExists('confirm_payments');
    }
}
