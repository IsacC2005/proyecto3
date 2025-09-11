<template>
    <div class="flex flex-col items-center justify-center min-h-[500px] text-center p-6">
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity lg:grow starting:opacity-0">
            <main
                class="relative flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg shadow-2xl lg:max-w-4xl lg:flex-row">
                <div class="flex flex-col items-center justify-center p-4 bg-white lg:w-1/2">
                    <div class="flex flex-row items-baseline">
                        <h1 class="inline pr-4 text-6xl font-[Montserrat] font-bold text-emerald-700">
                            EVA
                        </h1>
                        <h2 class="inline text-2xl Montserrat font-bold text-emerald-700">
                            Evaluación Asistida
                        </h2>
                    </div>

                    <h3 class="text-gray-600 text-[0.9rem] mb-4">
                        ¡Bienvenido!
                    </h3>
                    <p class="text-gray-600 text-center">

                    </p>
                    <Link href="/projects/create"
                        class="p-3 mt-14 text-2xl font-bold text-white bg-emerald-600 rounded-2xl shadow-2xl shadow-emerald-500 hover:scale-110 transition-all duration-150 animate-bounce">
                    Crear Proyecto
                    </Link>
                </div>

                <div class="relative flex items-center justify-center w-full h-96 lg:w-1/2">
                    <video src="/avatar.mp4" autoplay muted loop alt="GIF Transparente"
                        class="absolute inset-0 w-full h-full object-cover z-0"></video>

                    <div class="absolute inset-0 z-10 bg-gradient-to-t from-emerald-500 opacity-50"></div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
</script>

<style scoped>
/* You can add any scoped styles here if needed */
</style>