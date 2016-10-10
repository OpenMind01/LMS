<?php

namespace Pi\Providers;

use Illuminate\Support\ServiceProvider;
use Pi\Mail\Mailer;

class MailerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('p4mailer', function($app) {
            return new Mailer();
        });
    }
}
