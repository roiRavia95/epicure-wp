const {mix} = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin');


mix.webpackConfig(webpack=>{
    return{
        plugins:[
            new CompressionPlugin()
        ]
    }
})

mix.js('js/app.js', 'dist')
    .js('js/bag.js','dist/js')
    .js('js/meal-submit.js','dist/js')
    .js('js/mobile-menu.js','dist/js')
    .js('js/session-storage.js','dist/js')
    .js('js/checkout.js','dist/js/checkout')
    .js('js/dialog.js','dist/js/restaurants')
    .js('js/restaurant-meal-menu.js','dist/js/restaurants')
    .js('js/restaurant-scripts.js','dist/js/restaurants')
    .sass('sass/style.scss', 'dist/css')
    .sass('sass/custom-register.scss', 'dist/css')
    .sass('sass/custom-login.scss', 'dist/css')


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
    });

require('laravel-mix-versionhash');
mix.versionHash();