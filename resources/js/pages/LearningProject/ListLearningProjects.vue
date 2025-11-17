<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <div v-if="props.projects.data.length > 0" class="p-4 sm:p-6 md:p-8">
            <Heading title="Proyectos de Aprendizaje" />
            <template v-if="props.projects.links.length > 3">
                <Paginator :pages="props.projects.links"></Paginator>
            </template>
            <div v-for="(groupedProjects, index) in props.projects.data" :key="index" class="mb-10">
                <h2 class="text-2xl font-extrabold text-gray-800 mb-6 border-b-2 border-indigo-200 pb-2">
                    Seccion: {{ groupedProjects.section.grade }} ° {{ groupedProjects.section.section }} <br />
                    Año Escolar: {{ groupedProjects.section.schoolYear }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <Project v-for="project in groupedProjects.projects" :key="project.id" :project="project"
                        :section="`${groupedProjects.section.grade} ° ${groupedProjects.section.section} `">
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
import { defineProps } from 'vue';
import Project from './components/Project.vue';
import { LearningProject, Section, Pagination } from '@/types/dtos';
import Paginator from '../../components/Paginator.vue';
import Heading from '@/components/Heading.vue';
import { Link } from '@inertiajs/vue3';
import { BreadcrumbItem } from '@/types';

interface groupedProjects {
    section: Section
    projects: LearningProject[]
}

const props = defineProps<{
    projects: Pagination<groupedProjects>
}>()
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Lista de proyectos',
        href: '/learning-project/index',
    },
];
</script>