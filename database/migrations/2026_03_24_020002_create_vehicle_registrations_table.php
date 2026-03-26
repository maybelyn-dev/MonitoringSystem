<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('province');
            $table->year('year');
            $table->integer('private')->default(0);
            $table->integer('for_hire')->default(0);
            $table->integer('government')->default(0);
            $table->integer('diplomatic')->default(0);
            $table->integer('exempt')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_registrations');
    }
};
