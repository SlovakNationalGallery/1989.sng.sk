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

mix
  .autoload({
    jQuery: 'jquery',
    $: 'jquery',
    jquery: 'jquery',
    vue: 'Vue',
    axios: 'axios'
    // 'popper.js/dist/umd/popper.js': ['Popper'],
    // In case you imported plugins individually, you must also require them here:
    // Alert: 'exports-loader?Alert!bootstrap/js/dist/alert',
    // Button: 'exports-loader?Button!bootstrap/js/dist/button',
    // Carousel: 'exports-loader?Carousel!bootstrap/js/dist/carousel',
    // Collapse: 'exports-loader?Collapse!bootstrap/js/dist/collapse',
    // Dropdown: 'exports-loader?Dropdown!bootstrap/js/dist/dropdown',
    // Modal: 'exports-loader?Modal!bootstrap/js/dist/modal',
    // Popover: 'exports-loader?Popover!bootstrap/js/dist/popover',
    // Scrollspy: 'exports-loader?Scrollspy!bootstrap/js/dist/scrollspy',
    // Tab: 'exports-loader?Tab!bootstrap/js/dist/tab',
    // Tooltip: "exports-loader?Tooltip!bootstrap/js/dist/tooltip",
    // Util: 'exports-loader?Util!bootstrap/js/dist/util'
  })
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .extract(['vue', 'bootstrap', 'axios']);

if (mix.inProduction()) {
  mix
    .version()
    .disableNotifications()
    .webpackConfig({
      resolve: {
        alias: {
          'vue$': 'vue/dist/vue.min.js'
        }
      }
    })
    .options({ extractVueStyles: true })
};
