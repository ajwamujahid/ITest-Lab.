<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToBranchIdInRidersTable extends Migration
{
    public function up()
    {
        Schema::table('riders', function (Blueprint $table) {
            // First drop if exists (safe)
            $table->dropForeign(['branch_id']); // Add this line if it already exists
            // Then add foreign key
            $table->foreign('branch_id')
                ->references('id')
                ->on('branches')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('riders', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
        });
    }
}
