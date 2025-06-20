<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // 🔻 Drop existing foreign key to users table
            $table->dropForeign(['sender_id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            // 🔺 Add foreign key to patients table
            $table->foreign('sender_id')
                  ->references('id')
                  ->on('patients')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // 🔄 Rollback: Drop FK from patients
            $table->dropForeign(['sender_id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            // 🔁 Restore FK to users table
            $table->foreign('sender_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};
