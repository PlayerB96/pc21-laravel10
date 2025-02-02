export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        port: 8000, // Establece el puerto de Vite en 8000
        proxy: {
            "/fonts":
                "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/fonts",
        },
    },
});
