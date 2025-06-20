import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});


bezhansalleh/filament-shield
filament/filament
outerweb/filament-settings
solution-forest/filament-simplelightbox
laravel-shift/blueprint
barryvdh/laravel-debugbar
barryvdh/laravel-ide-helper
timwassenburg/laravel-service-generator
propaganistas/laravel-phone
rennokki/laravel-eloquent-query-cache
spatie/laravel-permission