<template>
    <div
        class="px-4 py-2 bg-white/30 backdrop-blur-sm rounded-md shadow-inner text-foreground font-semibold flex flex-col items-end">
        <div class="flex items-center gap-1">
            <p class="text-sm md:text-base">Estudiantes</p>
            <span class="text-lg">🎓</span>
        </div>
        <p class="text-[0.63rem] text-gray-700 font-normal">
            {{ props.students.length }} inscritos
        </p>
        <slot></slot>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Student } from '@/types/dtos';

const props = defineProps<{
    students: Student[]
}>();

</script>
