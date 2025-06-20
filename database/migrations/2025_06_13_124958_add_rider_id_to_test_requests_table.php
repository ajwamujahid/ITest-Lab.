<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('test_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('rider_id')->nullable()->after('branch');
        });
    }
    
    public function down()
    {
        Schema::table('test_requests', function (Blueprint $table) {
            $table->dropColumn('rider_id');
        });
    }
    
};
