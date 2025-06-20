<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUserIdFromTestRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('test_requests', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['user_id']); 
            
            // Then drop the column
            $table->dropColumn('user_id');
        });
    }

    public function down()
    {
        Schema::table('test_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();

            // If you want to restore the foreign key on rollback:
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
