<?php

namespace Pi\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('ifrole', function($roleName) {
            return "<?php if( \\Auth::user()->hasRole('{$roleName}') ): ?>";
        });
        Blade::directive('endifrole', function() {
            return '<?php endif ?>';
        });

        Blade::directive('snippet', function($text) {
            $data = [\Auth::user()];
            dd(\Snippet::process($text, $data));
            return \Snippet::process($text, $data);
        });
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
