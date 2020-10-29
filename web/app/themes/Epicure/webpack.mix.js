const mix = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');

mix.setPublicPath('dist')
mix.setResourceRoot('/app/themes/Epicure');

mix.webpackConfig(() => {
    return {
        plugins: [
            new CompressionPlugin(),
            new CopyWebpackPlugin({
                patterns: [
                        {
                            from: './images',
                            to: 'images',
                },
                        {
                            from: './js/sweetalert2.min.js',
                            to: 'js'
                },
                        {
                            from: './css/sweetalert2.min.css',
                            to: 'css'
                }
                ]
            }),
            new ImageminPlugin({
                test: /\.(jpe?g|png|gif|svg)$/i,
                plugins: [
                    imageminMozjpeg({
                        quality: 80,
                    })
                ]
            })
        ]
    }
});

mix
    .js('js/bag.js', 'dist/js/bag.js')
    .js('js/meal-submit.js', 'dist/js/meal-submit.js')
    .js('js/mobile-menu.js', 'dist/js/mobile-menu.js')
    .js('js/session-storage.js', 'dist/js/session-storage.js')
    .js('js/checkout.js', 'dist/js/checkout.js')
    .js('js/dialog.js', 'dist/js/dialog.js')
    .js('js/restaurant-meal-menu.js', 'dist/js/restaurant-meal-menu.js')
    .js('js/restaurant-scripts.js', 'dist/js/restaurant-scripts.js')
    .sass('sass/style.scss', 'dist/css/style.css')
    .sass('sass/custom-register.scss', 'dist/css/custom-register.css')
    .sass('sass/custom-login.scss', 'dist/css/custom-login.css')
    .sass('sass/normalize.scss','dist/css/normalize.css')


    .options({
        uglify: true,
        minify: true,
        uglifyOptions: {
            comments: false, // remove comments
            compress: {
                unused: true,
                dead_code: true, // big one--strip code that will never execute
                warnings: false, // good for prod apps so users can't peek behind curtain
                drop_debugger: true,
                conditionals: true,
                evaluate: true,
                drop_console: true, // strips console statements
                sequences: true,
                booleans: true,
            }
        }
    })

require('laravel-mix-versionhash');
mix.versionHash();