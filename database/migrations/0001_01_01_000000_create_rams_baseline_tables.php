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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('data_status')->default('active');
            $table->timestamps();
        });

        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('agency_name');
            $table->string('province');
            $table->string('address');
            $table->string('contact');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('agency');
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration')->index();
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration')->index();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained('agencies')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('budget', 15, 2);
            $table->enum('status', ['Planning', 'In Progress', 'Completed', 'On Hold', 'Cancelled'])->default('Planning');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('progress')->default(0)->comment('Progress percentage 0-100');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('economic_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->foreignId('province_id')->nullable()->constrained('provinces')->cascadeOnDelete();
            $table->year('year');
            $table->decimal('banking_liabilities', 15, 2)->nullable();
            $table->decimal('universal_banks', 15, 2)->nullable();
            $table->decimal('thrift_banks', 15, 2)->nullable();
            $table->decimal('rural_banks', 15, 2)->nullable();
            $table->decimal('operating_income', 15, 2)->nullable();
            $table->string('data_type')->default('banking');
            $table->timestamps();
        });

        Schema::create('vehicle_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->foreignId('province_id')->nullable()->constrained('provinces')->cascadeOnDelete();
            $table->year('year');
            $table->string('classification')->default('total');
            $table->integer('private_vehicles')->default(0);
            $table->integer('for_hire')->default(0);
            $table->integer('government')->default(0);
            $table->integer('diplomatic')->default(0);
            $table->integer('exempt')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();
        });

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
        Schema::dropIfExists('vehicle_registrations');
        Schema::dropIfExists('economic_data');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('agencies');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('regions');
    }
};
