import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class', // Habilita el modo oscuro basado en clases
    theme: {
        extend: {
            colors: {
                lightBackground: '#E5F4FF', // Color para el modo light
                darkBackground: '#1A202C', // Color para el modo dark
                lightText: '#1A202C',
                darkText: '#FFFFFF',
                primaryLight: '#3B82F6',
                primaryDark: '#2563EB',
            },
        },
    },
    plugins: [],
};
