<template>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700 truncate">{{ props.student.name + " " + student.surname
        }}</h2>
        <!-- Reemplazamos el span por la barra de progreso -->
        <div class="w-24 bg-gray-200 rounded-full h-2.5">
            <!-- <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300 ease-in-out"
                :style="{ width: studentProgress(student) + '%' }"></div> -->
        </div>
    </div>

    <div v-for="indicator in DailyClass.indicators" :key="indicator.id"
        class="w-full flex flex-row items-center px-2 gap-x-4 border rounded mb-2">
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
        </div>
    </div>
</template>

<script setup lang="ts">
import { Student } from '@/types/dtos';

const props = defineProps<{
    student: Student
}>();


</script>