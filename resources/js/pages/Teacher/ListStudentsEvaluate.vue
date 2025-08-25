<template>
    <AppLayout>
        <div class="p-4 sm:p-6 md:p-8">
            <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">Lista de Estudiantes</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div v-for="student in studentsWithGrades" :key="student.id"
                    class="bg-background rounded-lg shadow-md p-6 transform transition-transform duration-300 hover:scale-105"
                    :class="{ 'bg-green-100': student.isGraded }">

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700 truncate">{{ student.name + " " +
                            student.surname }}</h2>
                        <span v-if="student.isGraded" class="text-sm font-medium text-green-700">Calificado</span>
                    </div>

                    <div class="w-full">
                        <label :for="'grade-select-' + student.id" class="block text-sm font-medium text-gray-600 mb-1">
                            Selecciona una calificación:
                        </label>
                        <select :id="'grade-select-' + student.id" v-model="student.degree"
                            @change="updateStudentStatus(student)"
                            class="mt-1 block text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="" disabled>-- Selecciona --</option>
                            <option v-for="gradeOption in gradeOptions" :key="gradeOption.value"
                                :value="gradeOption.value">
                                {{ gradeOption.label }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, watchEffect } from 'vue';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

// Definimos la lista de opciones de calificación
const gradeOptions = [
    { label: '🚀🎉 Plenamente Logrado', value: 5 },
    { label: '😎 Logrado', value: 4 },
    { label: '🛠️ En Proceso', value: 3 },
    { label: '🔄 Por Mejorar', value: 2 },
    { label: '❌ Sin Lograr', value: 1 }
];

const props = defineProps({
    students: {
        type: Array as () => {
            id: number;
            name: string;
            surname: string;
        }[],
        required: true
    }
});

// Usamos ref para crear un estado reactivo para los estudiantes
const studentsWithGrades = ref([]);

// Cuando las props cambian, inicializamos el estado local
watchEffect(() => {
    studentsWithGrades.value = props.students.map(student => ({
        ...student,
        degree: null,
        isGraded: false
    }));
});

// Función para actualizar el estado del estudiante
const updateStudentStatus = (student) => {
    student.isGraded = student.grade !== null && student.grade !== '';

    router.post('/teacher/evaluate/class/save', {
        evaluation_id: -1,
        student_id: student.id,
        note: 'PL',
    }, {
        preserveState: true,
        replace: true,
        only: ['students']
    });
};
</script>
