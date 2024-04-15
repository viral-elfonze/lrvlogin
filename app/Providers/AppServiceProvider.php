<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
    public function boot(): void
    {
        Validator::extend('max_decimal', function ($attribute, $value, $parameters, $validator) {
            // Split the value to get the integer and decimal parts
            $parts = explode('.', $value);
            
            // Check if the value has both integer and decimal parts
            if (count($parts) != 2) {
                return false;
            }
    
            // Check if the integer part is less than or equal to the provided maximum
            if ($parts[0] > $parameters[0]) {
                return false;
            }
    
            // Check if the decimal part is less than or equal to 11
            if ($parts[1] > 11) {
                return false;
            }
    
            return true;
        });
    }
}
