<script setup lang="ts">

const props = defineProps < { studentName: string, studentId: number } > ()
</script>

<template>
    <header class="mb-8 p-4 bg-white rounded-xl shadow-lg border-b-4 border-primary-blue">
        <h1 class="text-3xl font-extrabold text-dark-text">
            Vista del Boletín Escolar
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Gestión del desempeño de {{ props.studentName }} (ID: {{ props.studentId }})
        </p>
    </header>
</template>