<?php

namespace Pi\Snippets;

use Illuminate\Support\ServiceProvider;

class SnippetServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Pi\Snippets\SnippetService', function ($app) {
            return new SnippetService();
        });
    }
}