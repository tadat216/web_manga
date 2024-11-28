import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js", 
        "./resources/**/*.vue",
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            backgroundColor: {
                'dark': '#1a202c',
                'light': '#ffffff'
            },
            textColor: {
                'dark': '#ffffff', 
                'light': '#000000'
            },
            borderColor: {
                'dark': '#2d3748',
                'light': '#e2e8f0'  
            }
        },
    },

    plugins: [forms],
};
