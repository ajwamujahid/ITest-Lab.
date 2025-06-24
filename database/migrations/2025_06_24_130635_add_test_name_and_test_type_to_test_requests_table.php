<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('test_requests', function (Blueprint $table) {
            $table->string('test_name')->after('patient_id');
            $table->enum('test_type', ['online', 'physical'])->after('test_name');
        });
    }

    public function down()
    {
        Schema::table('test_requests', function (Blueprint $table) {
            $table->dropColumn(['test_name', 'test_type']);
        });
    }
};

