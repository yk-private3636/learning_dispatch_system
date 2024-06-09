import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/admin/app.ts'
                ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@admin': path.resolve(__dirname, 'resources/js/admin')
        }
    },
     server: {
        host: true,
        port: 5173,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true
        }
    }
});
