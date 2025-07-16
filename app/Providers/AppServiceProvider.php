<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([

                NavigationGroup::make()
                    ->label('Repair Management'),
                    
                NavigationGroup::make()
                    ->label('Customer Management'),


                NavigationGroup::make()
                    ->label('Device Management'),

                


                NavigationGroup::make()
                    ->label('Financial Management'),

                

                NavigationGroup::make()
                    ->label('Communication'),
            ]);
        });
    }
}
