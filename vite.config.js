import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import fs from 'fs';

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
                'node_modules/@fortawesome/fontawesome-free/css/all.min.css'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~admin-lte': path.resolve(__dirname, 'node_modules/admin-lte'),
            '~@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),
            jquery: 'jquery/dist/jquery.js',
        }
    },
    build: {
        commonjsOptions: {
            include: ['node_modules/**'],
        },
        rollupOptions: {
            plugins: [
                {
                    name: 'copy-assets',
                    closeBundle() {
                        const srcDir = 'node_modules/@fortawesome/fontawesome-free/webfonts';
                        const destDir = 'public/webfonts';
                        
                        // Create destination directory if it doesn't exist
                        if (!fs.existsSync(destDir)) {
                            fs.mkdirSync(destDir, { recursive: true });
                        }
                        
                        // Copy each font file
                        fs.readdirSync(srcDir).forEach(file => {
                            fs.copyFileSync(
                                `${srcDir}/${file}`,
                                `${destDir}/${file}`
                            );
                        });
                    }
                }
            ]
        }
    }
});
