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
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Azul Fixaro: confianza, marca, acciones secundarias
                brand: {
                    50: '#EEF4FF',
                    100: '#DCE7FF',
                    200: '#B5CCFF',
                    300: '#80A8FF',
                    400: '#4580FF',
                    500: '#1A66FF',
                    600: '#0A5CFF',
                    700: '#0047D6',
                    800: '#0039AB',
                    900: '#002E87',
                },
                // Naranja urgencia: CTA principal y pedidos urgentes
                urgent: {
                    50: '#FFF3EE',
                    100: '#FFE3D6',
                    200: '#FFC3A8',
                    400: '#FF8155',
                    500: '#FF5A1F',
                    600: '#EB4710',
                    700: '#C2370A',
                },
                // Tinta: textos y superficies oscuras
                ink: {
                    50: '#F5F7FB',
                    100: '#EBEFF6',
                    200: '#D6DCE8',
                    300: '#AEB8CC',
                    400: '#7D89A3',
                    500: '#56627D',
                    600: '#3B4762',
                    700: '#26324D',
                    800: '#16213D',
                    900: '#0B1736',
                },
                ok: {
                    50: '#ECFDF3',
                    100: '#D1FADF',
                    500: '#12B76A',
                    600: '#039855',
                    700: '#027A48',
                },
            },
            borderRadius: {
                '4xl': '2rem',
            },
            boxShadow: {
                card: '0 1px 2px rgba(11, 23, 54, 0.04), 0 4px 16px -4px rgba(11, 23, 54, 0.08)',
                lift: '0 12px 32px -8px rgba(11, 23, 54, 0.18)',
                cta: '0 10px 24px -8px rgba(255, 90, 31, 0.55)',
            },
        },
    },

    plugins: [forms],
};
