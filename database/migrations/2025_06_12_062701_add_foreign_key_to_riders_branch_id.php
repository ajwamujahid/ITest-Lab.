<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
    {
        Schema::table('riders', function (Blueprint $table) {
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('riders', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
        });
    }
    
};
