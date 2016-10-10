<?php
/**
 * Created by Justin McCombs.
 * Date: 9/29/15
 * Time: 9:10 AM
 */

namespace Pi\Providers;


use Illuminate\Support\ServiceProvider;
use Pi\Auth\User;
use Pi\Http\ViewComposers\AuthorizedViewComposer;
use Pi\Http\ViewComposers\DiscussionViewComposer;
use Pi\Http\ViewComposers\NavigationViewComposer;
use Pi\Http\ViewComposers\ResourcesViewComposer;
use Pi\Http\ViewComposers\SnippetsViewComposer;
use Pi\Http\ViewComposers\BannersViewComposer;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', AuthorizedViewComposer::class);
        view()->composer(['layouts.partials.nav-top', 'layouts.partials.nav-left'], NavigationViewComposer::class);
        view()->composer('partials.snippets.*', SnippetsViewComposer::class);
        view()->composer('partials.banners.list', BannersViewComposer::class);
        view()->composer('*', ResourcesViewComposer::class);
        view()->composer('layouts.partials.nav-left', DiscussionViewComposer::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function register()
    {

    }
}
