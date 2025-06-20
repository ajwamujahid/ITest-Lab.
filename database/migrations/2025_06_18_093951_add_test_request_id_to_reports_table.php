<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('reports', function (Blueprint $table) {
        $table->unsignedBigInteger('test_request_id')->nullable()->after('patient_id');

        $table->foreign('test_request_id')
              ->references('id')->on('test_requests')
              ->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
};
