<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planrequests', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('product');
            $table->string('plan');
            $table->string('name');
            $table->string('phone');
            $table->string('payment');
            $table->string('voucher');
            $table->string('status');
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
        Schema::dropIfExists('planrequests');
    }
}
