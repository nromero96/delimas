<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgrampricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programprices', function (Blueprint $table) {
            $table->id();
            $table->integer('id_program');
            $table->string('textcategoryprice');
            $table->string('color');
            $table->decimal('oneprice',10,2);
            $table->decimal('fiveprice',10,2);
            $table->decimal('tenprice',10,2);
            $table->decimal('twentyprice',10,2);
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programprices');
    }
}
