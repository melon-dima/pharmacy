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
        Schema::create('auth_rule', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->text('data')->nullable();
            $table->timestamps();
        });

        Schema::create('auth_item', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->unsignedTinyInteger('type');
            $table->text('description')->nullable();
            $table->string('rule_name')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->foreign('rule_name')
                ->references('name')
                ->on('auth_rule')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::create('auth_item_child', function (Blueprint $table) {
            $table->string('parent');
            $table->string('child');

            $table->primary(['parent', 'child']);
            $table->foreign('parent')
                ->references('name')
                ->on('auth_item')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('child')
                ->references('name')
                ->on('auth_item')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::create('auth_assignment', function (Blueprint $table) {
            $table->string('item_name');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->nullable();

            $table->primary(['item_name', 'user_id']);
            $table->foreign('item_name')
                ->references('name')
                ->on('auth_item')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('title')->nullable();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['role_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('auth_assignment');
        Schema::dropIfExists('auth_item_child');
        Schema::dropIfExists('auth_item');
        Schema::dropIfExists('auth_rule');
    }
};
