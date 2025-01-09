import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        proxy: {
            '/fonts': 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/fonts',
        },
    },
});
