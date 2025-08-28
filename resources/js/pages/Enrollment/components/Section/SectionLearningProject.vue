<template>
    <div class="absolute bottom-3 left-4 w-1/2 p-2 bg-white/30 backdrop-blur-sm rounded-md shadow-inner">
        <h2 class="text-xs md:text-sm font-bold text-gray-800">Proyecto de Aprendizaje</h2>
        <Link :href="`/learning-project/show/${props.learningProject.id}`"
            class="text-gray-700 text-[0.6rem] hover:underline line-clamp-2">
        {{ props.learningProject.title }}
        </Link>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import { LearningProject } from '@/types/dtos';

const props = defineProps<{
    learningProject: LearningProject
}>()
</script>
