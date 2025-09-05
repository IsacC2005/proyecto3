<template>

    <div
        class="bg-white rounded-lg shadow-md p-6 transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">

        <h2 class="text-xl font-bold mb-2 text-indigo-600 truncate">
            {{ project.title }}
        </h2>

        <div class="border-b border-gray-200 mb-4 pb-2">
            <p v-if="project.dailyClasses && project.dailyClasses.length > 0" class="text-sm text-gray-500">
                <span class="font-semibold">Inicio:</span> {{ formatDate(project.dailyClasses[0].date) }}
            </p>
            <p v-else class="text-sm text-gray-500">
                No hay clases programadas.
            </p>
        </div>

        <div class="mb-4">
            <h3 class="font-semibold text-gray-700 mb-2">Clases Principales:</h3>
            <ul class="space-y-2">
                <li v-for="(dailyClass, index) in getFirstClasses(project.dailyClasses)" :key="dailyClass.id"
                    class="flex items-start">
                    <span class="text-indigo-500 mr-2 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span class="text-sm text-gray-600">{{ index + 1 }}. {{ dailyClass.title }}</span>
                </li>
            </ul>
        </div>

        <div class="mt-4 text-right">
            <Link :href="`/learning-project/show/${project.id}`"
                class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
            Ver detalles &rarr;
            </Link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import { DailyClass, LearningProject } from '@/types/dtos';

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = defineProps<{
    project: LearningProject
}>()

/**
 * Formatea una fecha a un formato legible.
 * @param dateObject El objeto de fecha de la API.
 */
const formatDate = (dateObject) => {
    // Si el objeto de fecha no es válido, retorna un string vacío.
    if (!dateObject || !dateObject.date) {
        return '';
    }
    const date = new Date(dateObject.date);
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

/**
 * Retorna las primeras N clases de un proyecto.
 * @param dailyClasses El array de clases diarias.
 * @param count El número de clases a mostrar.
 */
const getFirstClasses = (dailyClasses: DailyClass[], count = 3) => {
    return dailyClasses ? dailyClasses.slice(0, count) : [];
};
</script>

<style>
/* Aquí puedes agregar estilos personalizados si es necesario,
   pero Tailwind maneja la mayoría de los casos */
.group:hover .text-primary-400 {
    color: #1600e0;
    /* Color personalizado para el hover de la letra grande */
}

.group:hover .text-primary-600 {
    color: #059669;
    /* Color personalizado para el hover del grado */
}

.group:hover .text-secondary-500 {
    color: #000000;
    /* Color personalizado para el hover del profesor */
}
</style>
