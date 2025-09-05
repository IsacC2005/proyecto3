<template>
    <span class="text-base font-medium text-gray-600">{{ indicator.title }}</span>
    <div>
        <select :id="'grade-select-' + student.id + '-' + indicator.id" v-model="student.grade[indicator.id]"
            @change="saveGrade(student, indicator)"
            class="mt-1 block text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <option value="" disabled>-- Selecciona --</option>
            <option v-for="gradeOption in gradeOptions" :key="gradeOption.value" :value="gradeOption.value">
                {{ gradeOption.label }}
            </option>
        </select>
</template>

<script setup lang="ts">
const gradeOptions = [
    { label: '🚀🎉 Plenamente Logrado', value: 'PL' },
    { label: '😎 Logrado', value: 'L' },
    { label: '🛠️ En Proceso', value: 'EP' },
    { label: '🔄 Por Mejorar', value: 'PM' },
    { label: '❌ Sin Lograr', value: 'NL' }
];
</script>