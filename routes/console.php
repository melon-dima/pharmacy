<?php

use Database\Seeders\RbacSeeder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('rbac:init {--force : Run in production mode}', function () {
    $this->info('Running migrations...');
    $this->call('migrate', [
        '--force' => (bool) $this->option('force'),
    ]);

    $this->info('Seeding RBAC data...');
    $this->call('db:seed', [
        '--class' => RbacSeeder::class,
        '--force' => (bool) $this->option('force'),
    ]);

    $this->newLine();
    $this->info('RBAC initialization complete.');
})->purpose('Initialize RBAC tables and seed base RBAC data');
