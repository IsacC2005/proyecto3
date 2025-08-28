<template>
    <div
        class="px-3 py-1 bg-gradient-to-r from-teal-500 to-emerald-600 text-white font-bold rounded-full shadow-md transform hover:scale-105 transition-transform">
        <p class="text-sm md:text-base">
            {{ GradeList[0][props.grade] }}
        </p>
    </div>
</template>

<script setup lang="ts">
import { Grade } from '@/types/dtos';

const props = defineProps<{
    grade: Grade;
}>();

const GradeList = [
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
