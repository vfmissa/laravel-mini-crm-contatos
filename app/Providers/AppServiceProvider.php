<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Infrastructure\Contact\Repositories\EloquentContactRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContactRepositoryInterface::class, EloquentContactRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}