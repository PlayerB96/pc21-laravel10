const mix = require("laravel-mix");

// Compilar los archivos CSS con Tailwind
mix.postCss("resources/css/app.css", "public/css", [require("tailwindcss")]);

// Habilitar Vue.js en Laravel Mix
mix.js("resources/js/app.js", "public/js").vue(); // Aquí agregamos el soporte de Vue.js
// .js("resources/js/home.js", "public/js") // Otro archivo para la página de inicio
// .sass("resources/sass/app.scss", "public/css")
// .sass("resources/sass/home.scss", "public/css"); // Otra hoja de estilos para la página de inicio
