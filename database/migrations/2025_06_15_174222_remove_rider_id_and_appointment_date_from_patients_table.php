<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'rider_id')) {
                $table->dropColumn('rider_id');
            }
            if (Schema::hasColumn('patients', 'appointment_date')) {
                $table->dropColumn('appointment_date');
            }
        });
    }
    
public function down()
{
    Schema::table('patients', function (Blueprint $table) {
        $table->string('rider_id')->nullable();
        $table->date('appointment_date')->nullable();
    });
}

};
