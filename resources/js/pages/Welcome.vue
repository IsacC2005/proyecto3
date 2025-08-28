<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';
const isDarkMode = ref(false); // Variable reactiva para el estado del tema

const esTemaOscuro = computed(() => isDarkMode.value);

let mediaQueryList;

onMounted(() => {
    if (window.matchMedia) {
        mediaQueryList = window.matchMedia('(prefers-color-scheme: dark)');

        // Establece el estado inicial
        isDarkMode.value = mediaQueryList.matches;

        // Escucha los cambios
        mediaQueryList.addEventListener('change', (e) => {
            isDarkMode.value = e.matches;
        });
    }
});

onUnmounted(() => {
    if (mediaQueryList) {
        mediaQueryList.removeEventListener('change', (e) => {
            isDarkMode.value = e.matches;
        });
    }
});
</script>

<template>

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-gradient-to-br from-emerald-100 to-blue-100 p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">

        <div class="flex w-full items-center justify-center opacity-100 transition-opacity lg:grow starting:opacity-0">
            <main
                class="relative flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg shadow-2xl lg:max-w-4xl lg:flex-row">

                <div class="flex flex-col items-center justify-center p-4 bg-white lg:w-1/2">
                    <div class="flex flex-row items-baseline">
                        <h1 class="inline pr-4   text-6xl font-[Montserrat] font-bold text-emerald-700">EVA</h1>
                        <h2 class="inline text-2xl Montserrat font-bold text-emerald-700">
                            Evaluación
                            Asistida</h2>
                    </div>

                    <h3 class="text-gray-600 text-[0.9rem] mb-4">Planificar, registrar, evaluar. Juntos, creamos el
                        futuro.
                    </h3>
                    <p class="text-gray-600 text-center">Bienvenido. Sabemos que tu tiempo es valioso y tu vocación,
                        fundamental. Nos unimos a ti para optimizar la planificación, simplificar la evaluación y darte
                        más espacio para lo que realmente importa: enseñar.
                    </p>
                    <Link href="/dashboard"
                        class="p-3 mt-14 text-2xl font-bold text-white bg-emerald-600 rounded-2xl shadow-2xl shadow-emerald-500 hover:scale-110 transition-all duration-150 animate-bounce">
                    Comenzar
                    </Link>
                </div>

                <div class="relative flex items-center justify-center w-full h-96 lg:w-1/2">
                    <video src="/avatar.mp4" autoplay muted loop alt="GIF Transparente"
                        class="absolute inset-0 w-full h-full object-cover z-0"></video>

                    <div class="absolute inset-0 z-10 bg-gradient-to-t from-emerald-500 opacity-50">
                    </div>
                </div>

            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
