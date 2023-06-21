<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // \Illuminate\Support\Facades\Validator::extend('one_word', function ($attribute, $value, $parameters, $validator) {
        //     return preg_match('/^\w+$/', $value);
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
