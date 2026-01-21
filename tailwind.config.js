import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    primary: '#fd2800',
                    dark: '#171717',
                    gray: '#444444',
                    light: '#ededed',
                }
            },
            fontFamily: {
                heading: ['Poppins', 'Helvetica', 'Arial', 'sans-serif'],
                body: ['Helvetica', 'Arial', 'sans-serif'],
            }
        },
    },
    plugins: [],
}

