const mix = require('laravel-mix');
require('laravel-mix-polyfill')

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

mix
  .webpackConfig({
      resolve: {
          alias: {
              '@': path.resolve('resources/sass')
          }
      }
  })
  .js('resources/js/app.js', 'public/js')
  .copy('resources/js/edit.js', 'public/js')
  .copy('node_modules/openseadragon/build/openseadragon/images', 'public/vendor/openseadragon/images')
  .sass('resources/sass/app.scss', 'public/css')
  .polyfill({ enabled: true })
  .extract(['vue', 'bootstrap', 'axios']);

if (mix.inProduction()) {
  mix
    .version()
    .disableNotifications()
    .options({ extractVueStyles: true })
};
