<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('employees', function (Blueprint $table) {
        // Add role_id foreign key
        $table->foreignId('role_id')->nullable()->after('email')->constrained('roles')->nullOnDelete();

        // Optionally, drop the old 'role' string column if no longer needed
        $table->dropColumn('role');
    });
}

public function down()
{
    Schema::table('employees', function (Blueprint $table) {
        $table->string('role')->after('email'); // add back old column
        $table->dropForeign(['role_id']);
        $table->dropColumn('role_id');
    });
}

};
