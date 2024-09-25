<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->id();

            $table->integer('id_programprice')->index('id_programprice_programprices');
            $table->integer('id_customer')->index('id_customer_customers');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('number_of_days');
            $table->integer('quantity_of_menu');
            $table->decimal('unitprice_moment', 10, 2);
            $table->decimal('total_price', 10, 2);
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
        Schema::dropIfExists('periods');
    }
}
