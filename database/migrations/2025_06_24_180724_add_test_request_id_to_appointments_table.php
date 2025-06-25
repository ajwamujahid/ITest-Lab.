<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('test_request_id')->nullable()->after('id');
    
            // Optional: If you want foreign key
            $table->foreign('test_request_id')->references('id')->on('test_requests')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            //
        });
    }
};
