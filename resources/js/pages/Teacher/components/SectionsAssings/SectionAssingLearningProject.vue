<template>
    <div class="p-2 bg-white/30 backdrop-blur-sm rounded-md shadow-inner">
        <Link href='/learning-project/create' :data="{ teacherId: props.teacherId, enrollmentId: props.enrollmentId }"
            class="text-gray-700 text-[0.6rem] hover:underline line-clamp-2">

        <h2 class="text-xs md:text-sm font-bold text-gray-800">Proyectos de Aprendizaje</h2>
        </Link>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import { LearningProject } from '@/types/dtos';

const props = defineProps<{
    teacherId?: number,
    enrollmentId?: number,
}>()
</script>