<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToBranchesTable extends Migration
{
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('zip_code', 10)->nullable()->after('location');
            $table->decimal('latitude', 10, 7)->nullable()->after('zip_code');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->text('address')->nullable()->after('longitude');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('country', 100)->nullable()->after('state');
            $table->string('phone', 20)->nullable()->after('country');
            $table->string('email')->nullable()->after('phone');
            $table->string('status')->default('active')->after('email');
            $table->string('manager_name')->nullable()->after('status');
            $table->time('opening_time')->nullable()->after('manager_name');
            $table->time('closing_time')->nullable()->after('opening_time');
        });
    }

    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn([
                'zip_code',
                'latitude',
                'longitude',
                'address',
                'city',
                'state',
                'country',
                'phone',
                'email',
                'status',
                'manager_name',
                'opening_time',
                'closing_time',
            ]);
        });
    }
}
