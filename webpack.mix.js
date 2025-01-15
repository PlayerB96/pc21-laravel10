const mix = require('laravel-mix');

mix.postCss('resources/css/app.css', 'public/css', [
    require('tailwindcss'),
]);
// webpack.mix.js

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/home.js', 'public/js') // Otro archivo para la página de inicio
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/home.scss', 'public/css'); // Otra hoja de estilos para la página de inicio

