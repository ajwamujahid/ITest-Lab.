<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagementTable extends Migration
{
    public function up()
    {
        Schema::create('management', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            // Add any other fields you need
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('management');
    }
}
