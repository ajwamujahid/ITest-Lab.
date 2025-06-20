<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('complaints', function (Blueprint $table) {
        $table->id();
        $table->string('patient_name');  // or user_id if auth
        $table->text('complaint_text');
        $table->enum('target_role', ['super_admin', 'admin']);
        $table->string('branch');
        $table->string('attachment')->nullable();

        // Add this new column for status with default value 'pending'
        $table->enum('status', ['pending', 'in-progress', 'resolved', 'rejected'])->default('pending');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
