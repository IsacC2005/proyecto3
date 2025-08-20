<template>
    <AppLayout>
        <div class="p-6 md:p-12 bg-gray-100 min-h-screen">
            <h1 class="text-3xl md:text-5xl font-extrabold text-center text-gray-800 mb-8 md:mb-12 drop-shadow-md">
                Secciones de Matrícula</h1>
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 justify-items-center">
                <div v-for="(section, index) in sections" :key="index"
                    class="relative w-full aspect-square bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out cursor-pointer group">

                    <div class="absolute inset-0 flex items-center justify-start p-6 md:p-8">
                        <p
                            class="text-7xl md:text-8xl lg:text-9xl font-black text-gray-200 group-hover:text-primary-400 transition-colors duration-300 ease-in-out">
                            {{ section.initial }}
                        </p>
                    </div>

                    <div class="absolute inset-0 flex flex-col items-end justify-between p-4 md:p-6 text-right z-10">
                        <h2
                            class="text-lg md:text-2xl font-bold text-gray-800 group-hover:text-primary-600 transition-colors duration-300 ease-in-out">
                            {{ section.grade }}
                        </h2>
                        <p
                            class="text-xs md:text-sm text-gray-500 group-hover:text-secondary-500 transition-colors duration-300 ease-in-out">
                            {{ section.teacher }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';

const sections = ref([
    { initial: 'A', grade: 'Primer Grado', teacher: 'Prof. Ana García' },
    { initial: 'B', grade: 'Segundo Grado', teacher: 'Prof. Carlos Ramírez' },
    { initial: 'C', grade: 'Tercer Grado', teacher: 'Prof. María Pérez' },
    { initial: 'D', grade: 'Cuarto Grado', teacher: 'Prof. Juan Torres' },
    { initial: 'E', grade: 'Quinto Grado', teacher: 'Prof. Luisa Castro' },
    { initial: 'F', grade: 'Sexto Grado', teacher: 'Prof. Pedro Ruiz' },
]);
</script>

<style>
/* Aquí puedes agregar estilos personalizados si es necesario,
   pero Tailwind maneja la mayoría de los casos */
.group:hover .text-primary-400 {
    color: #a7f3d0;
    /* Color personalizado para el hover de la letra grande */
}

.group:hover .text-primary-600 {
    color: #059669;
    /* Color personalizado para el hover del grado */
}

.group:hover .text-secondary-500 {
    color: #3b82f6;
    /* Color personalizado para el hover del profesor */
}
</style>
