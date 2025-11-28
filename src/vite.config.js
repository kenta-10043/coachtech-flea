import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: true,
        hmr: {
            host: "localhost",
        },
    },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/chat_create.js",
                "resources/js/rating.js",
                "resources/js/purchase.js",
                "resources/js/profile_image.js",
                "resources/js/profile_rating.js",
                "resources/js/sell.js",
            ],
            refresh: true,
        }),
    ],
});
