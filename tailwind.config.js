const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    mode: 'jit',

    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },

            borderWidth: {
                default: '1px',
                '0': '0',
                '2': '2px',
                '3': '3px',
                '4': '4px',
                '6': '6px',
                '8': '8px',
            },

            colors: {
                ...colors,
                blue: {
                    DEFAULT: '#47cdff',
                    light: '#8ae2fe',
                    dark: '#45c2ef'
                }
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },

        // colors
    },

    plugins: [require('@tailwindcss/forms')],
};
