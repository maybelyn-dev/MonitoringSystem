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
            $table->string('code')->unique();
            $table->timestamps();
        });

        DB::table('provinces')->insert([
            ['name' => 'Aurora', 'code' => 'AUR', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bataan', 'code' => 'BAT', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bulacan', 'code' => 'BUL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nueva Ecija', 'code' => 'NEC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pampanga', 'code' => 'PAM', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tarlac', 'code' => 'TAR', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zambales', 'code' => 'ZAM', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
