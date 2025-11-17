<script setup lang="ts">
import { Student } from '@/types/dtos';

const props = defineProps<{
    student: Student
}>()
</script>


<template>
    <h2 class="text-xl sm:text-2xl font-bold text-primary-blue mb-4 pb-2 border-b-2 border-secondary-gray">
        Información del Estudiante
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8 text-dark-text">
        <div class="flex flex-col">
            <span class="font-medium text-gray-500">Nombre Completo:</span>
            <span class="text-lg font-semibold">{{ props.student.name }}</span>
        </div>
        <div class="flex flex-col">
            <span class="font-medium text-gray-500">Grado/Nivel:</span>
            <span class="text-lg font-semibold">{{ props.student.grade }}</span>
        </div>
        <div class="flex flex-col">
            <span class="font-medium text-gray-500">ID del Estudiante:</span>
            <span class="text-lg font-semibold">{{ props.student.id }}</span>
        </div>
        <div class="flex flex-col">
            <span class="font-medium text-gray-500">ID de la Escuela:</span>
            <span class="text-lg font-semibold">{{ props.student.schoolId }}</span>
        </div>
    </div>
</template>