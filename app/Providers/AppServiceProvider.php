<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Infrastructure\Contact\Repositories\ContactRepository;
use App\Domain\Contact\Events\EventDispatcherInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        

        $this->app->bind(EventDispatcherInterface::class, function ($app) {
            return new class implements EventDispatcherInterface {
                public function dispatch(object $event): void {
                    // Uses Laravel's global event helper to fire the domain event
                    event($event); 
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}