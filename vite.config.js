import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: "0.0.0.0", // Esto está bien
        port: 5173,
        hmr: {
            host: "192.168.151.59", // Añade tu IP local aquí
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});