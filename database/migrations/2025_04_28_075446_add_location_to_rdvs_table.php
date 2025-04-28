<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationToRdvsTable extends Migration
{
    public function up()
    {
        Schema::table('rdvs', function (Blueprint $table) {
            $table->string('location', 255)->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('rdvs', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
}
