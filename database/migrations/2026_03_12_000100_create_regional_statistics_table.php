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
        Schema::create('regional_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('province');
            $table->string('category');
            $table->string('sub_category');
            $table->unsignedInteger('year');
            $table->decimal('value', 15, 2)->nullable();
            $table->timestamps();

            $table->index(['province', 'category', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regional_statistics');
    }
};
