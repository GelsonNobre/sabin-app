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
        extend: {},
    },

    // Add daisyUI
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")["light"],
                    //primary: "#B81116",
                },
                dark: {
                    ...require("daisyui/src/theming/themes")["dark"],
                    //primary: "#B81116",
                },
            },
        ],
    },
}
