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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');


const css = 'public/assets/css';
const js = 'public/assets/js';

mix.js('./resources/js/stisla.js', js + '/app.js')
    .sass('./resources/sass/stisla/components.scss', css)
    .sass('./resources/sass/stisla/style.scss', css)
    .sass('./resources/sass/mystyle.scss', css + '/custom.css')