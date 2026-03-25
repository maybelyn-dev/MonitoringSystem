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
                if (!Schema::hasColumn('vehicle_registrations', 'region_id')) {
                    $table->foreignId('region_id')->nullable()->after('id')->constrained('regions')->nullOnDelete();
                }
                if (!Schema::hasColumn('vehicle_registrations', 'province_id')) {
                    $table->foreignId('province_id')->nullable()->after('region_id')->constrained('provinces')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('economic_data')) {
            Schema::table('economic_data', function (Blueprint $table) {
                if (!Schema::hasColumn('economic_data', 'region_id')) {
                    $table->foreignId('region_id')->nullable()->after('id')->constrained('regions')->nullOnDelete();
                }
                if (!Schema::hasColumn('economic_data', 'province_id')) {
                    $table->foreignId('province_id')->nullable()->after('region_id')->constrained('provinces')->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('vehicle_registrations')) {
            Schema::table('vehicle_registrations', function (Blueprint $table) {
                if (Schema::hasColumn('vehicle_registrations', 'province_id')) {
                    $table->dropForeign(['province_id']);
                    $table->dropColumn('province_id');
                }
                if (Schema::hasColumn('vehicle_registrations', 'region_id')) {
                    $table->dropForeign(['region_id']);
                    $table->dropColumn('region_id');
                }
            });
        }

        if (Schema::hasTable('economic_data')) {
            Schema::table('economic_data', function (Blueprint $table) {
                if (Schema::hasColumn('economic_data', 'province_id')) {
                    $table->dropForeign(['province_id']);
                    $table->dropColumn('province_id');
                }
                if (Schema::hasColumn('economic_data', 'region_id')) {
                    $table->dropForeign(['region_id']);
                    $table->dropColumn('region_id');
                }
            });
        }
    }
};