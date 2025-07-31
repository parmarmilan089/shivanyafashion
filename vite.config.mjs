import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: '127.0.0.1',
        port: 5173,
        origin: 'http://127.0.0.1:5173',
        cors: {
            origin: 'http://127.0.0.1:8000',
            methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            allowedHeaders: ['Content-Type', 'Authorization'],
        },
        hmr: {
            host: '127.0.0.1',
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

// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import vue from '@vitejs/plugin-vue';

// export default defineConfig({
//     server: {
//         host: 'shivanyafashion.local',
//         port: 5173,
//         origin: 'http://shivanyafashion.local:5173',
//         cors: {
//             origin: 'http://shivanyafashion.local:8000',
//             methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
//             allowedHeaders: ['Content-Type', 'Authorization'],
//         },
//         hmr: {
//             host: 'shivanyafashion.local',
//         },
//     },
//     plugins: [
//         laravel({
//             input: ['resources/js/app.js'],
//             refresh: true,
//         }),
//         vue(),
//     ],
// });
