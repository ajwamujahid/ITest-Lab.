<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->unsignedBigInteger('rider_id')->nullable()->after('branch_id');
    });
}

public function down()
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->dropColumn('rider_id');
    });
}

};
