const mix = require('laravel-mix');
require('laravel-mix-purgecss');

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

mix.options({ processCssUrls: false });

mix.js('resources/js/app.js', 'public/js')
  .js('resources/js/gallery.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .purgeCss({
    whitelist: ['modal-backdrop', 'text-cdblg', 'custom-checkbox', 'custom-select', 'gallery-grid__flairs', 'fas', 'fa-lock', 'fa-home'],
    whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /form/, /alert/, /carousel/, /item/, /custom-control/, /textarea/, /latest-images/],
  })
  .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
  .webpackConfig({
    module: {
      rules: [
        {
          test: /\.tsx?$/,
          loader: 'ts-loader',
          exclude: /node_modules/,
        },
      ],
    },
    resolve: {
      extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx'],
    },
  });
