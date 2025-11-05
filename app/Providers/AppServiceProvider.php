<?php

namespace App\Providers;
use App\Http\Controllers\CompteController;
use App\Services\CompteService;
use App\Repository\CompteRepository;
use Illuminate\Support\ServiceProvider;
use App\Models\Compte;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CompteRepository::class,function($app){
            return new CompteRepository(new Compte());
        });
        $this->app->singleton(CompteService::class,function($app){
            return new CompteService($app->make(CompteRepository::class));
        });
        $this->app->singleton(CompteController::class,function($app){
            return new CompteController($app->make(CompteService::class));
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
