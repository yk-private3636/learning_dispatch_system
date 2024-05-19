import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/admin/app.js'
                ],
            refresh: true,
        }),
        vue(),
    ],
     server: {
        host: true,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true
        }
    }
});
