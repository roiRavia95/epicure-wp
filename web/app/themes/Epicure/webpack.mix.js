const {mix} = require('laravel-mix');

mix.js('js/app.js', './')
    .sass('sass/style.scss', './')
    .sass('sass/custom-register.scss', './css')
    .sass('sass/custom-login.scss', './css')
