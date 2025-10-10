<template>
    <AppLayout>
        <div v-if="projects.length !== 0" class="p-4 sm:p-6 md:p-8">
            <Heading title="Proyectos de Aprendizaje" />

            <div v-for="(projectsByYear, schoolYear) in groupedProjects" :key="schoolYear" class="mb-10">

                <h2 class="text-2xl font-extrabold text-gray-800 mb-6 border-b-2 border-indigo-200 pb-2">
                    Año Escolar: {{ schoolYear }}
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <Project v-for="project in projectsByYear" :key="project.id" :project="project">
                    </Project>
                </div>
            </div>
        </div>

        <div v-else>
            <Heading title="No tienes proyectos de aprendizaje"
                description="Aún no tienes proyectos de aprendizaje creados, primero debes crear un proyecto de aprendizaje para alguna seccion que tengas asignada" />
            <Link href="/teacher/enrollments-assigns/"
                class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors duration-200">
            Ver las secciones
            </Link>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps, computed } from 'vue'; // Importar 'computed'
import Project from './components/Project.vue';
import { LearningProject } from '@/types/dtos';
import Heading from '@/components/Heading.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    projects: LearningProject[]
}>()

// --- PROPIEDAD COMPUTADA PARA AGRUPAR Y ORDENAR ---
const groupedProjects = computed(() => {
    // 1. Clonar y ordenar la lista principal por ID (más reciente primero)
    const sortedProjects = [...props.projects].sort((a, b) => b.id - a.id);

    // 2. Agrupar los proyectos por el año escolar
    const grouped = sortedProjects.reduce((acc, project) => {
        // Obtenemos la clave de agrupamiento
        const year = project.enrollment?.schoolYear;

        // Inicializamos el array para ese año si no existe
        if (!acc[year]) {
            acc[year] = [];
        }

        // Añadimos el proyecto al grupo
        acc[year].push(project);
        return acc;
    }, {} as Record<string, LearningProject[]>);

    // 3. Ordenar los grupos por Año Escolar (descendente)
    // Asumimos que "2024-2025" > "2023-2024". Ordenamos las claves alfabéticamente.
    return Object.keys(grouped)
        .sort((a, b) => b.localeCompare(a)) // Ordena las claves (Años) de forma descendente
        .reduce((orderedAcc, key) => {
            orderedAcc[key] = grouped[key];
            return orderedAcc;
        }, {} as Record<string, LearningProject[]>);
});
</script>