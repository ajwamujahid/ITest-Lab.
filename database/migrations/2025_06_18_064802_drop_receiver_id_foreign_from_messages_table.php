<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('messages', function (Blueprint $table) {
        $table->dropForeign(['receiver_id']);
        // Optionally: make nullable if needed
        // $table->unsignedBigInteger('receiver_id')->nullable()->change();
    });
}

public function down()
{
    Schema::table('messages', function (Blueprint $table) {
        $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
    });
}

};
