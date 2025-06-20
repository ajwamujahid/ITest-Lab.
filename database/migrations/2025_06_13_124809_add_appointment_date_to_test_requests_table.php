<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('test_requests', function (Blueprint $table) {
        $table->dateTime('appointment_date')->nullable();
    });
}

public function down()
{
    Schema::table('test_requests', function (Blueprint $table) {
        $table->dropColumn('appointment_date');
    });
}

};
