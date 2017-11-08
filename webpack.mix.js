let mix = require('laravel-mix');

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
mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/fonts/bootstrap')
   .js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.sass', 'public/css');
