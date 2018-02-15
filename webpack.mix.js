let mix = require('laravel-mix')

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

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.vue$/,
                use: [
                    {
                        loader: 'iview-loader',
                        options: {
                            prefix: true
                        }
                    }
                ]
            }
        ]
    }
})

mix
    .js('resources/assets/js/app.js', 'public/js')
    .stylus('resources/assets/stylus/app.styl', 'public/css')

if (mix.inProduction()) {
    mix.version()
}
