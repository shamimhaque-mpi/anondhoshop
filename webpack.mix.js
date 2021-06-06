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

mix.js('resources/assets/backend/js/app.js', 'public/js/backend').sourceMaps()

   .sass('resources/assets/backend/sass/app.scss', 'public/css/backend').options({
		processCssUrls: false
	});

mix.js('resources/assets/frontend/js/app.js', 'public/js/frontend').sourceMaps()

   .sass('resources/assets/frontend/sass/app.scss', 'public/css/frontend').options({
		processCssUrls: false
	});
