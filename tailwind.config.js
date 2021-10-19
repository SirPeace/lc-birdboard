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
                'primary': 'var(--primary-color)',
                'primary-light': 'var(--primary-light-color)',
                'primary-dark': 'var(--primary-dark-color)',
            },

            textColor: {
                'default': 'var(--text-default-color)',
                'muted': 'var(--text-muted-color)',
                'label': 'var(--text-label-color)',
            },

            backgroundColor: {
                'body': 'var(--background-body-color)',
                'card': 'var(--background-card-color)',
                'hover': 'var(--background-hover-color)',
                'input': 'var(--background-input-color)',
                'navbar': 'var(--background-navbar-color)',
                'sidebar': 'var(--background-sidebar-color)',
                'modal': 'var(--background-modal-color)',
            },

            borderColor: {
                'input': 'var(--border-input-color)',
                'navbar': 'var(--border-navbar-color)',
            },

            ringColor: {
                'primary': 'rgba(71, 205, 255, var(--tw-ring-opacity))'
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
