<?php

namespace App\Providers;

use App\Models\User;
use App\Services\RbacService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Src\Modules\Users\Repositories\EloquentUserRepository;
use Src\Modules\Users\Repositories\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user, string $ability) {
            return app(RbacService::class)->hasPermission($user, $ability) ? true : null;
        });
    }
}
