import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/app_admin.css',
                'resources/js/app_admin.js',
                'resources/backend/adminlte/dist/adminlte.min.css',
                'resources/backend/adminlte/dist/adminlte.min.js',
                'resources/backend/adminlte/dist/bootstrap.min.css',
                'resources/backend/adminlte/dist/bootstrap.bundle.min.js',
                'resources/backend/adminlte/dist/all.min.css'
            ],
            refresh: true,
        }),
    ],
});
