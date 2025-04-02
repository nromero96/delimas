<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistrictAndDocumentToPlanrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planrequests', function (Blueprint $table) {
            $table->string('district')->nullable()->after('address');
            $table->string('document')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planrequests', function (Blueprint $table) {
            $table->dropColumn('district');
            $table->dropColumn('document');
        });
    }
}
