import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: 'shivanyafashion.com',
        port: 5173,
        origin: 'http://shivanyafashion.com:5173',
        cors: {
            origin: ['http://shivanyafashion.com:8001'],
            methods: ['GET', 'POST'],
            allowedHeaders: ['Content-Type'],
        },
        hmr: {
            host: 'shivanyafashion.com',
            port: 5173,
            protocol: 'ws',
        },
    },

    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});