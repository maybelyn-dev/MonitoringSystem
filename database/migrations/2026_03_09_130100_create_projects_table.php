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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained('agencies')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('budget', 15, 2);
            $table->enum('status', ['Planning', 'In Progress', 'Completed', 'On Hold', 'Cancelled'])->default('Planning');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('progress')->default(0)->comment('Progress percentage 0-100');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
