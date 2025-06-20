<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->id(); // Primary key (BIGINT)
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('photo')->nullable(); // Rider profile picture
            $table->string('vehicle_type')->nullable(); // e.g., bike, car
            $table->string('vehicle_number')->nullable(); // Registration number
            $table->string('cnic')->nullable(); // National ID
            $table->string('address')->nullable();
            $table->string('status')->default('active'); // active/inactive
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riders');
    }
}
