<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('branch_admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('qualification');
            $table->string('cnic');
            $table->text('address')->nullable();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
    
            // Add new fields here:
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('university')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('profile_picture')->nullable();
    
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_admins');
    }
};
