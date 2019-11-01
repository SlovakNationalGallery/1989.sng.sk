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

mix.options({
    // see https://github.com/JeffreyWay/laravel-mix/issues/432
    // otherwise 'npm run watch' rebuilds in infinite loop without changing anything
    processCssUrls: false  
})
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .extract(['vue', 'bootstrap', 'axios']);

if (mix.inProduction()) {
  mix
    .version()
    .disableNotifications()
    .options({ extractVueStyles: true })
};
