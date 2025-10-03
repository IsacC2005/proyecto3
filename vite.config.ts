import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { VitePWA } from 'vite-plugin-pwa';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            includeAssets: ['favicon.ico', 'apple-touch-icon.png', 'images/icons/*.png'],

            manifest: {
                name: 'Evaluacion Asistida aaa',
                short_name: 'EVA',
                description: 'Herramienta de gestión de boletines educativos.',
                theme_color: '#42b983', // Color de la barra de estado del teléfono
                background_color: '#ffffff',
                start_url: '/',
                scope: '/build',
                // CRUCIAL: Muestra la app sin la barra de direcciones del navegador
                display: 'standalone',

                // 4. ICONOS: Necesarios para que el navegador muestre el prompt de instalación
                icons: [
                    {
                        "src": "/images/icons/icon-192.png",
                        "sizes": "192x192",
                        "type": "image/png"
                    },
                    {
                        "src": "/images/icons/icon-512.png",
                        "sizes": "512x512",
                        "type": "image/png"
                    },
                    {
                        "src": "/images/icons/apple-touch-icon.png",
                        "sizes": "180x180",
                        "type": "image/png"
                    }
                ],
                screenshots: [
                    {
                        "src": "/build/screenshots/desktop-main.png",
                        "sizes": "1280x720",
                        "type": "image/png",
                        "form_factor": "wide",
                        "label": "Vista principal de la aplicación"
                    },
                    {
                        "src": "/build/screenshots/mobile-main.png",
                        "sizes": "720x1280",
                        "type": "image/png",
                        "form_factor": "narrow",
                        "label": "Vista principal en el teléfono"
                    }
                ]

            }, workbox: {
                dest: 'public/build'
            },
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
