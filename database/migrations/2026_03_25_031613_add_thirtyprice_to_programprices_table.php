<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThirtypriceToProgrampricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programprices', function (Blueprint $table) {
            $table->decimal('thirtyprice',10,2)->after('twentyprice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programprices', function (Blueprint $table) {
            $table->dropColumn('thirtyprice');
        });
    }
}
