<template>

    <div v-for="enrollment in enrollments" :key="enrollment.id" class="relative w-full aspect-square bg-sidebar rounded-2xl shadow-xl overflow-hidden transform hover:scale-105
        transition-transform duration-300 ease-in-out cursor-pointer group">
        <div class="group absolute inset-0 flex items-center justify-start p-6 md:p-8">
            <p
                class="text-9xl md:text-8xl lg:text-9xl font-black text-chart-2 group-hover:rotate-4 transition-all duration-300 ease-in-out">
                {{ enrollment.section.toString().toUpperCase() }}
            </p>
        </div>

        <div class="absolute inset-0 flex flex-col items-end justify-between p-4 md:p-6 text-right z-10">
            <h2 class="text-lg md:text-2xl font-bold text-foreground duration-300 ease-in-out">
                {{ grade[0][enrollment.degree] }}
            </h2>
            <div
                class="px-1 rounded-lg bg-transparent border border-chart-1 text-foreground font-semibold shadow shadow-chart-1 hover:scale-105 hover:bg-primary-100 transition-all duration-200 cursor-pointer">


                <div v-if="enrollment.learning_project">
                    <a href="#">
                        {{ enrollment.learning_project.title }}
                    </a>
                </div>
                <div v-else>
                    <Link method="get" href="/learning-project/create/"
                        :data="{ enrollment_id: enrollment.id, teacher_id: enrollment.teacher.id }">
                    Crear Proyecto de Aprendizaje
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

type Enrollment = {
    id: number;
    schoole_year: string;
    schoole_moment: number;
    degree: number;
    section: string;
    classroom: number,
    teacher: Teacher,
    learning_project?: {
        id: number;
        title: string;
    };
}

type Teacher = {
    id: number;
    name: string;
    surname: string;
    email: string;
}

// eslint-disable-next-line @typescript-eslint/no-unused-vars

const props = defineProps({
    enrollments: {
        type: Array as () => Enrollment[],
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
