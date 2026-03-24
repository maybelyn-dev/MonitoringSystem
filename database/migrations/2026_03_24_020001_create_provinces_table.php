<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('provinces')->insert([
            ['name' => 'Aurora', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bataan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bulacan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nueva Ecija', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pampanga', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tarlac', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zambales', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
