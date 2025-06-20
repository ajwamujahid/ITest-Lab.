<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('test_requests', function (Blueprint $table) {
            $table->dropColumn('rider_id');
            $table->dropColumn('appointment_date');
        });
    }

    public function down(): void
    {
        Schema::table('test_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('rider_id')->nullable();
            $table->dateTime('appointment_date')->nullable();
        });
    }
};
