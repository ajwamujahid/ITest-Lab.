<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rider_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('rider_id');
            $table->enum('status', ['scheduled', 'on_the_way', 'nearby', 'arrived', 'delayed', 'completed'])->default('scheduled');
            $table->timestamp('scheduled_at')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('vehicle_info')->nullable();
            $table->string('rider_photo')->nullable();
            $table->timestamps();
    
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('rider_id')->references('id')->on('riders')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rider_visits');
    }
};
