import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#82C17D', // Main Brand Green
                    light: '#D1E7D0',   // Light Background Green
                    dark: '#4A7C47',    // Text Green
                }
            },
            boxShadow: {
                'soft': '0 20px 40px rgba(0,0,0,0.06)',
            }
        },
    },

    plugins: [forms],
};
