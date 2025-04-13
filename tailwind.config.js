/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        // You will probably also need these lines
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",

        // Add mary
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",

        // Pagination
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                // Adicione sua paleta aqui para uso direto com classes do Tailwind
                teal: {
                    50: '#F2FBFA',   // Mais claro
                    100: '#D3F4F1',
                    200: '#A7E8E2',
                    300: '#73D5D1',
                    400: '#46BBB9',
                    500: '#30ABAB',  // Base
                    600: '#217F80',
                    700: '#1F6366',
                    800: '#1D4F52',
                    900: '#1C4345',
                    950: '#0A2729',  // Mais escuro
                }
            }
        },
    },

    // Add daisyUI
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")["light"],
                    // Cores base para tema claro
                    "primary": "#30ABAB",           // Cor 500 da sua paleta
                    "secondary": "#73D5D1",         // Cor 300 da sua paleta
                    "accent": "#217F80",            // Cor 600 da sua paleta
                    "neutral": "#1F6366",           // Cor 700 da sua paleta
                    "base-100": "#F2FBFA",          // Cor 50 da sua paleta - fundo principal
                    "base-200": "#D3F4F1",          // Cor 100 da sua paleta - fundo secundário
                    "base-300": "#A7E8E2",          // Cor 200 da sua paleta - elementos de UI
                    "base-content": "#0A2729",      // Cor 950 da sua paleta - texto sobre base
                    "info": "#46BBB9",              // Cor 400 da sua paleta
                    "--rounded-box": "0.5rem",      // Bordas arredondadas para caixas
                    "--rounded-btn": "0.3rem",      // Bordas arredondadas para botões
                },
                dark: {
                    ...require("daisyui/src/theming/themes")["dark"],
                    // Cores base para tema escuro
                    "primary": "#30ABAB",           // Cor 500 da sua paleta
                    "secondary": "#217F80",         // Cor 600 da sua paleta
                    "accent": "#46BBB9",            // Cor 400 da sua paleta
                    "neutral": "#1F6366",           // Cor 700 da sua paleta
                    "base-100": "#0A2729",          // Cor 950 da sua paleta - fundo principal
                    "base-200": "#1C4345",          // Cor 900 da sua paleta - fundo secundário
                    "base-300": "#1D4F52",          // Cor 800 da sua paleta - elementos de UI
                    "base-content": "#D3F4F1",      // Cor 100 da sua paleta - texto sobre base
                    "info": "#73D5D1",              // Cor 300 da sua paleta
                    "--rounded-box": "0.5rem",      // Bordas arredondadas para caixas
                    "--rounded-btn": "0.3rem",      // Bordas arredondadas para botões
                },
            },
        ],
    },
}