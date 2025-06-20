<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSenderIdForeignOnMessages extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            // 🧨 Drop the foreign key if it exists
            $table->dropForeign(['sender_id']);
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            // 🛠 Restore the foreign key constraint (if ever needed)
            $table->foreign('sender_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }
}
