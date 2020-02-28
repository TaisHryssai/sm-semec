const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/assets/js')
   .sass('resources/sass/app.scss', 'public/assets/css')
   .sass('resources/sass/login/session.scss', 'public/assets/css/login')
   .sass('resources/sass/admin/home.scss', 'public/assets/css/home');

mix.copyDirectory('resources/vendor/assets', 'public/assets/vendor');
mix.copyDirectory('resources/images', 'public/assets/images');
