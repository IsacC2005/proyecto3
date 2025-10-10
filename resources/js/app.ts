import '../css/app.css';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';


import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';

import { loadFull } from "tsparticles";
import Particles from "@tsparticles/vue3";


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const pinia = createPinia();

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/build/sw.js') // El archivo que genera el plugin de Vite
            .then(registration => {
                console.log('SW registrado:', registration);
            })
            .catch(error => {
                console.log('Fallo registro de SW:', error);
            });
    });
}

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .use(Particles, {
                // 2. Aquí se configura el plugin
                // El método loadFull carga todos los efectos
                init: async (engine) => {
                    await loadFull(engine);
                },
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});


// This will set light / dark mode on page load...
initializeTheme();
