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
        Schema::create('economic_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->foreignId('province_id')->nullable()->constrained('provinces')->onDelete('cascade');
            $table->year('year');
            $table->decimal('banking_liabilities', 15, 2)->nullable();
            $table->decimal('universal_banks', 15, 2)->nullable();
            $table->decimal('thrift_banks', 15, 2)->nullable();
            $table->decimal('rural_banks', 15, 2)->nullable();
            $table->decimal('operating_income', 15, 2)->nullable();
            $table->string('data_type')->default('banking'); // banking, vehicles, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('economic_data');
    }
};
