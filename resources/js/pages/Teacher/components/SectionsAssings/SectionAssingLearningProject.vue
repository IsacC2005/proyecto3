<template>
    <div class="p-2 bg-white/30 backdrop-blur-sm rounded-md shadow-inner">
        <h2 class="text-xs md:text-sm font-bold text-gray-800">Proyecto de Aprendizaje</h2>
        <Link v-if="props.learningProject" :href="`/learning-project/show/${props.learningProject.id}`"
            class="text-gray-700 text-[0.6rem] hover:underline line-clamp-2">
        {{ props.learningProject.title }}
        </Link>
        <Link v-else href='/learning-project/create'
            :data="{ teacherId: props.teacherId, enrollmentId: props.enrollmentId }"
            class="text-gray-700 text-[0.6rem] hover:underline line-clamp-2">
        Crear un proyecto para esta seccion
        </Link>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import { LearningProject } from '@/types/dtos';

const props = defineProps<{
    learningProject?: LearningProject,
    teacherId?: number,
    enrollmentId?: number,
}>()
</script>