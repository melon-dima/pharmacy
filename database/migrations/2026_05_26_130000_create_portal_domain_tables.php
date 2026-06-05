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
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable()->unique();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pharmacy_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('position')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('hired_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pharmacy_id')->constrained()->cascadeOnDelete();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('status')->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('time_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('logged_at');
            $table->string('type');
            $table->string('source')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('frequency')->default('daily');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('checklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });

        Schema::create('checklist_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pharmacy_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('submitted_at');
            $table->string('status')->default('pending');
            $table->integer('overdue_minutes')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });

        Schema::create('employee_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->text('reason')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('decided_at')->nullable();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->json('payload')->nullable();
            $table->foreignId('generated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('generated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('exchange_logs', function (Blueprint $table) {
            $table->id();
            $table->string('system')->default('1c');
            $table->string('direction')->default('outbound');
            $table->string('status')->default('pending');
            $table->json('payload')->nullable();
            $table->text('response')->nullable();
            $table->dateTime('exchanged_at')->nullable();
            $table->timestamps();
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->nullable();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_events', function (Blueprint $table) {
            $table->id();
            $table->string('level')->default('info');
            $table->string('message');
            $table->string('context')->nullable();
            $table->foreignId('pharmacy_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('happened_at');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('level')->default('info');
            $table->boolean('is_published')->default(true);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('activity_events');
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('exchange_logs');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('employee_requests');
        Schema::dropIfExists('checklist_submissions');
        Schema::dropIfExists('checklist_items');
        Schema::dropIfExists('checklists');
        Schema::dropIfExists('time_logs');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('pharmacies');
    }
};
