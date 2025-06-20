<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('test_requests', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('test_requests', function (Blueprint $table) {
            $table->dropColumn('patient_id');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }
    

};
