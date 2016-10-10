var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    //mix.less('nifty-template/nifty.less', 'public/assets/css');
    mix.less('p4/p4.less', 'public/assets/css');
    // mix.coffee('p4.coffee', 'public/assets/js');
});
