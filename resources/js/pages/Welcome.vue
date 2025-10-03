<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Vector from './Animations/Vector.vue';

</script>

<template>

    <Head title="Bienvenido">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <Vector></Vector>


    <div
        class="flex min-h-screen flex-col items-center bg-gradient-to-br from-emerald-100 to-blue-100 p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">

        <div class="w-full flex justify-end z-10">
            <a target="_blank"
                class="px-4 py-2 m-2 rounded-xl text-emerald-100 font-extrabold bg-gradient-to-l from-emerald-400 to-blue-300 shadow-emerald-950 shadow-2xl hover:scale-105 transition-all"
                href="https://sigesin.japeco.com/">
                japeco
            </a>
        </div>
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity lg:grow starting:opacity-0">
            <main
                class="relative flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg shadow-2xl lg:max-w-4xl lg:flex-row">

                <div class="flex flex-col items-center justify-center p-4 pt-10 bg-white/80 lg:w-1/2">
                    <div class="flex flex-row items-baseline-last">
                        <img src="logo_eva.png" alt="" class="w-30">
                        <h2 class="inline text-2xl font-sans font-bold text-emerald-700">
                            Evaluación
                            Asistida</h2>
                    </div>

                    <h3 class="text-gray-600 text-[0.9rem] font-sans mt-4 mb-4">Planificar, registrar, evaluar. Juntos,
                        creamos el
                        futuro.
                    </h3>
                    <p class="text-gray-600 text-center px-5">Bienvenido. Sabemos que tu tiempo es
                        valioso y tu
                        vocación,
                        fundamental. Nos unimos a ti para optimizar la planificación, simplificar la evaluación y
                        darte
                        más espacio para lo que realmente importa: enseñar.
                    </p>
                    <Link href="/dashboard"
                        class="p-3 mt-8 text-2xl font-bold text-white bg-emerald-600 rounded-2xl shadow-2xl shadow-emerald-500 hover:scale-110 transition-all duration-150 animate-bounce">
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
