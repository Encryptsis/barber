import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/acceso.css',
                'resources/css/generales.css',
                'resources/css/preloader.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/index.js',
                'resources/js/preloader.js',
            ],
            refresh: true,
        }),
    ],
});
