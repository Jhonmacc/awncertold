import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            outputDir: 'public/build', // Defina o diretório de saída aqui
            refresh: true,
        }),
    ],
});
