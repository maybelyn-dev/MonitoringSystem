<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('vehicle_registrations')) {
            Schema::table('vehicle_registrations', function (Blueprint $table) {
                if (!Schema::hasColumn('vehicle_registrations', 'classification')) {
                    $table->string('classification')->nullable()->after('year');
                }
                if (!Schema::hasColumn('vehicle_registrations', 'private_vehicles')) {
                    $table->integer('private_vehicles')->default(0)->after('private');
                }
            });
        }

        if (Schema::hasTable('economic_data')) {
            Schema::table('economic_data', function (Blueprint $table) {
                if (!Schema::hasColumn('economic_data', 'data_type')) {
                    $table->string('data_type')->nullable()->after('year');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('vehicle_registrations')) {
            Schema::table('vehicle_registrations', function (Blueprint $table) {
                if (Schema::hasColumn('vehicle_registrations', 'private_vehicles')) {
                    $table->dropColumn('private_vehicles');
                }
                if (Schema::hasColumn('vehicle_registrations', 'classification')) {
                    $table->dropColumn('classification');
                }
            });
        }

        if (Schema::hasTable('economic_data')) {
            Schema::table('economic_data', function (Blueprint $table) {
                if (Schema::hasColumn('economic_data', 'data_type')) {
                    $table->dropColumn('data_type');
                }
            });
        }
    }
};