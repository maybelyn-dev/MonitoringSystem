<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('economic_data', function (Blueprint $table) {
            $table->id();
            $table->string('province');
            $table->year('year');
            $table->decimal('universal_commercial_banks', 15, 2)->nullable();
            $table->decimal('thrift_banks', 15, 2)->nullable();
            $table->decimal('rural_cooperative_banks', 15, 2)->nullable();
            $table->decimal('operating_income', 15, 2)->nullable();
            $table->decimal('total_liabilities', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('economic_data');
    }
};
