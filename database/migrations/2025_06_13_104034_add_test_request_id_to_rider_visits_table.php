<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rider_visits', function (Blueprint $table) {
            $table->unsignedBigInteger('test_request_id')->nullable()->after('patient_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rider_visits', function (Blueprint $table) {
            //
        });
    }
};
