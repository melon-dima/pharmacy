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
        Schema::table('medicines', function (Blueprint $table) {
            $table->unsignedInteger('price_cents')->default(0)->after('dosage_form');
            $table->char('currency', 3)->default('RUB')->after('price_cents');
            $table->string('external_system')->nullable()->after('is_active');
            $table->string('external_id')->nullable()->after('external_system');

            $table->unique(['external_system', 'external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropUnique(['external_system', 'external_id']);
            $table->dropColumn(['price_cents', 'currency', 'external_system', 'external_id']);
        });
    }
};
