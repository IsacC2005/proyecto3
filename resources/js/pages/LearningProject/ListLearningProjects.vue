<template>
    <AppLayout>
        {{ page.props.flash }}
        <div v-if="projects.length !== 0" class="p-4 sm:p-6 md:p-8">
            <Heading title="Proyectos de Aprendizaje" />
            <div v-for="(project, index) in props.projects" :key="index"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <Project :project="project"></Project>
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
import { defineProps } from 'vue';
import Project from './components/Project.vue';
import { LearningProject } from '@/types/dtos';
import Heading from '@/components/Heading.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const props = defineProps<{
    projects: LearningProject[]
}>()

// const props = defineProps({
//     projects: {
//         type: Array,
//         required: true
//     }
// });



</script>
