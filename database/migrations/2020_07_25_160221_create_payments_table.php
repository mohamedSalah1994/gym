<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoicenumber')->nullable();
            $table->string('invoiceid')->nullable();
            $table->unsignedBigInteger('user');
            $table->foreign('user')->references('id')->on('users');
            $table->string('plan');
            $table->string('status');
            $table->string('amount');
            $table->string('currency');
            $table->string('created_by')->nullable();
            $table->string('paid')->nullable()->default('tap'); // tap mean online , ketnet , cash
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
        Schema::dropIfExists('payments');
    }
}
