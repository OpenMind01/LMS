<?php

namespace Pi\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('unique_to_client', 'Pi\Validation\ClientValidator@uniqueToClient');
        Validator::extend('unique_to_course', 'Pi\Validation\ClientValidator@uniqueToCourse');
        Validator::extend('slug', 'Pi\Validation\SlugValidator@validate');
        Validator::replacer('slug', 'Pi\Validation\SlugValidator@getMessage');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
