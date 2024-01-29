import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/css/theme.css',
                'resources/css/user.css',
                // 'resources/css/theme-rtl.css',
                //'resources/css/user-rtl.css',
            ],
            refresh: true,
        }),
    ],
});
