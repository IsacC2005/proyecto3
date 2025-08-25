<template>
    <AppLayout>

        <div class="p-4 sm:p-6 md:p-8">
            <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">
                Proyectos de Aprendizaje
            </h1>


            <div v-for="project in projects"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <Project :project="project"></Project>
            </div>


            <div v-if="projects.length === 0" class="text-center py-10 text-gray-500">
                <p>Aún no hay proyectos de aprendizaje disponibles.</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Project from './components/Project.vue';

const props = defineProps({
    projects: {
        type: Array,
        required: true
    }
});



</script>
