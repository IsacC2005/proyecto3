<template>
    <div v-for="section in sections" :key="section.id" class="relative w-full aspect-square bg-sidebar rounded-2xl shadow-xl overflow-hidden transform hover:scale-105
        transition-transform duration-300 ease-in-out cursor-pointer group">

        <div class="group absolute inset-0 flex items-center justify-start p-6 md:p-8">
            <p
                class="text-9xl md:text-8xl lg:text-9xl font-black text-chart-2 group-hover:rotate-4 transition-all duration-300 ease-in-out">
                {{ section.section.toString().toUpperCase() }}
            </p>
        </div>

        <div class="absolute inset-0 flex flex-col items-end justify-between p-4 md:p-6 text-right z-10">
            <h2 class="text-lg md:text-2xl font-bold text-foreground duration-300 ease-in-out">
                {{ grade[0][section.degree] }}
            </h2>
            <div
                class="px-1 rounded-lg bg-transparent border border-chart-1 text-foreground font-semibold shadow shadow-chart-1 hover:scale-105 hover:bg-primary-100 transition-all duration-200 cursor-pointer">

                <p v-if="section.teacher"
                    class="text-xs md:text-sm text-gray-500 group-hover:text-secondary-500 transition-colors duration-300 ease-in-out">
                    {{ section.teacher.name + " " + section.teacher.surname }}
                </p>
                <div v-else>
                    <a :href="`/enrollment/assign-teacher/${section.id}`">
                        Asignar profesor
                    </a>
                </div>
            </div>
            <div v-if="section.learning_project"
                class="px-1 rounded-lg bg-transparent border border-chart-1 text-foreground font-semibold shadow shadow-chart-1 hover:scale-105 hover:bg-primary-100 transition-all duration-200 cursor-pointer">
                <Link :href="route('learning_projects.show', section.learning_project.id)">
                {{ section.learning_project.name }}
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    sections: {
        type: Array,
        required: true
    }
});


const grade = [
    {
        1: 'Primer Grado',
        2: 'Segundo Grado',
        3: 'Tercer Grado',
        4: 'Cuarto Grado',
        5: 'Quinto Grado',
        6: 'Sexto Grado'
    }
];
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
