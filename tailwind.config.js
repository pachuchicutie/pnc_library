const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontSize: {
                xxs: ".60rem",
            },
            colors: {
                cyan: "hsl(180, 66%, 49%)",
                cyanLight: "hsl(180, 66%, 69%)",
                darkViolet: "hsl(257, 27%, 26%)",
                grayishViolet: "hsl(257, 7%, 63%)",
                veryDarkBlue: "hsl(255, 11%, 22%)",
                veryDarkViolet: "hsl(260, 8%, 14%) ",
            },
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
                sans: ["Poppins", "sans-serif"],
                sans: ["Mulish", "sans-serif"],
                mono: ["Rokkitt", "monospace"],
            },
            spacing: {
                26: "6.5rem",
                180: "32rem",
            },
        },
    },

    variants: {
        extend: {},
    },

    plugins: [require("@tailwindcss/forms")],
};
