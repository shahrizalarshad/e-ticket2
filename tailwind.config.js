import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Brand palette tokens
                primary: colors.indigo,
                secondary: colors.cyan,
                accent: colors.violet,
                neutral: colors.slate,
                success: colors.emerald,
                warning: colors.amber,
                danger: colors.rose,
            },
        },
    },

    plugins: [forms],
};
