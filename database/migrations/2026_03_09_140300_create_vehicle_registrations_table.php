<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->foreignId('province_id')->nullable()->constrained('provinces')->onDelete('cascade');
            $table->year('year');
            $table->string('classification')->default('total'); // total, private, for_hire, government, diplomatic, exempt
            $table->integer('private_vehicles')->default(0);
            $table->integer('for_hire')->default(0);
            $table->integer('government')->default(0);
            $table->integer('diplomatic')->default(0);
            $table->integer('exempt')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_registrations');
    }
};
