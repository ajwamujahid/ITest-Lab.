<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('test_requests', function (Blueprint $table) {
        $table->decimal('total_amount', 10, 2)->after('payment_method')->default(0);
    });
}

public function down()
{
    Schema::table('test_requests', function (Blueprint $table) {
        $table->dropColumn('total_amount');
    });
}

};
