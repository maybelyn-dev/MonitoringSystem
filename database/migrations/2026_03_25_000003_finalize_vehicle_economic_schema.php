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
                if (Schema::hasColumn('vehicle_registrations', 'province') && !Schema::hasColumn('vehicle_registrations', 'province')) {
                    // no-op: preserving existing province column.
                }

                // Make existing province column nullable for seed updates.
                if (Schema::hasColumn('vehicle_registrations', 'province')) {
                    $table->string('province')->nullable()->change();
                }

                if (!Schema::hasColumn('vehicle_registrations', 'private_vehicles')) {
                    $table->integer('private_vehicles')->default(0)->after('private');
                }
            });
        }

        if (Schema::hasTable('economic_data')) {
            Schema::table('economic_data', function (Blueprint $table) {
                if (!Schema::hasColumn('economic_data', 'banking_liabilities')) {
                    $table->decimal('banking_liabilities', 15, 2)->nullable()->after('year');
                }
                if (!Schema::hasColumn('economic_data', 'universal_banks')) {
                    $table->decimal('universal_banks', 15, 2)->nullable()->after('banking_liabilities');
                }
                if (!Schema::hasColumn('economic_data', 'thrift_banks')) {
                    $table->decimal('thrift_banks', 15, 2)->nullable()->after('universal_banks');
                }
                if (!Schema::hasColumn('economic_data', 'rural_banks')) {
                    $table->decimal('rural_banks', 15, 2)->nullable()->after('thrift_banks');
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
            });
        }

        if (Schema::hasTable('economic_data')) {
            Schema::table('economic_data', function (Blueprint $table) {
                foreach (['banking_liabilities', 'universal_banks', 'thrift_banks', 'rural_banks'] as $col) {
                    if (Schema::hasColumn('economic_data', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};