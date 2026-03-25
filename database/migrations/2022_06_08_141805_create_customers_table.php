<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->id();
            $table->string('document_type', 20)->nullable();
            $table->string('document_number', 20)->nullable();
            $table->string('name')->nullable();
            $table->string('address');
            $table->string('district', 50);
            $table->string('phone', 20);
            $table->string('phone_two', 20)->nullable();
            $table->string('email', 192)->nullable();
            $table->text('restriction')->nullable();
            $table->text('recommendation')->nullable();
            $table->string('status', 20);
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
        Schema::dropIfExists('customers');
    }
}
