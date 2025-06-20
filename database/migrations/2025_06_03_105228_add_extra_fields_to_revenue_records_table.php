<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('revenue_records', function (Blueprint $table) {
        $table->string('payment_mode')->nullable()->after('payment_status');
        $table->decimal('discount_amount', 10, 2)->default(0)->after('amount_charged');
        $table->string('doctor_name')->nullable()->after('test_name');
        $table->integer('patient_count')->default(1)->after('patient_name');
    });
}

public function down(): void
{
    Schema::table('revenue_records', function (Blueprint $table) {
        $table->dropColumn(['payment_mode', 'discount_amount', 'doctor_name', 'patient_count']);
    });
}

};
