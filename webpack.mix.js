const mix = require('laravel-mix');
require('laravel-mix-imagemin');
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
  .js('resources/js/mycrop.js', 'public/js')
  .js('resources/js/post.js', 'public/js')
  .js('resources/js/main.js', 'public/js')
  .js('resources/js/project.js', 'public/js')
  .js('resources/js/resipi.js', 'public/js')
  .js('resources/js/chat.js', 'public/js')
  .js('resources/js/select.js', 'public/js')
  .js('resources/js/decision.js', 'public/js')
  .js('resources/js/mypage.js', 'public/js')
  .js('resources/js/search.js', 'public/js')
  .js('resources/js/chat_list.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/mycrop.scss', 'public/css');

