let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.setPublicPath('assets');

// mix.js('assets/js/theme.js', 'assets/js/theme3.min.js');
mix.js([
    'dev/app.js',
], 'assets/js/theme.min.js');

