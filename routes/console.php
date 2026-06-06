<?php

use Database\Seeders\RbacSeeder;
use App\Models\Medicine;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Src\Modules\Medicines\Domain\Search\MedicineSearchIndexerInterface;

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

Artisan::command('medicines:reindex-search', function (MedicineSearchIndexerInterface $indexer) {
    $count = 0;

    Medicine::query()
        ->where('is_active', true)
        ->orderBy('id')
        ->chunkById(100, function ($medicines) use ($indexer, &$count): void {
            foreach ($medicines as $medicine) {
                $indexer->index($medicine);
                $count++;
            }
        });

    $this->info("Indexed {$count} active medicines.");
})->purpose('Reindex active medicines into Elasticsearch');
