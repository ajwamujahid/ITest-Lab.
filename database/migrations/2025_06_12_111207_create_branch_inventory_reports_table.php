<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchInventoryReportsTable extends Migration
{
    public function up()
    {
        Schema::create('branch_inventory_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_admin_id');
            $table->string('report_type');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->date('report_date')->nullable();
            $table->json('item_ids');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Optional: add foreign keys if needed
            // $table->foreign('branch_admin_id')->references('id')->on('branch_admins')->onDelete('cascade');
            // $table->foreign('category_id')->references('id')->on('inventory_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('branch_inventory_reports');
    }
}
