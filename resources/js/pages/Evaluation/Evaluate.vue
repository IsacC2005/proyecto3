<template>
    <AppLayout>
        {{ props.DailyClass }}
        <div v-if="!props.DailyClass.indicators.length > 0">
            Esta clase no tiene indicadores de evaluacion,
        </div>
        <Heading title="Lista de estudiantes para evaluar"></Heading>
        <div class="p-4 sm:p-6 md:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <ListStudentEvaluate :allNote="props.allNote" :dailyClass="props.DailyClass" :students="props.students">
                </ListStudentEvaluate>
                <!-- <div v-for="student in studentsWithGrades" :key="student.id"
                    class="bg-background rounded-lg shadow-md p-6 transform transition-transform duration-300 hover:scale-105"
                    :class="{ 'bg-green-100': isFullyGraded(student) }">

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700 truncate">{{ student.name + " " + student.surname
                        }}</h2>
                        <-- Reemplazamos el span por la barra de progreso --
                        <div class="w-24 bg-gray-200 rounded-full h-2.5">
                            <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300 ease-in-out"
                                :style="{ width: studentProgress(student) + '%' }"></div>
                        </div>
                    </div>

                    <div v-for="indicator in DailyClass.indicators" :key="indicator.id"
                        class="w-full flex flex-row items-center px-2 gap-x-4 border rounded mb-2">
                        <span class="text-base font-medium text-gray-600">{{ indicator.title }}</span>
                        <div>
                            <select :id="'grade-select-' + student.id + '-' + indicator.id"
                                v-model="student.grade[indicator.id]" @change="saveGrade(student, indicator)"
                                class="mt-1 block text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="" disabled>-- Selecciona --</option>
                                <option v-for="gradeOption in gradeOptions" :key="gradeOption.value"
                                    :value="gradeOption.value">
                                    {{ gradeOption.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, watchEffect, computed } from 'vue';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import ListStudentEvaluate from './components/ListStudentEvaluate.vue';
import { Indicator, Student } from '@/types/dtos';

// Definimos la lista de opciones de calificación con la nueva escala.
const gradeOptions = [
    { label: '🚀🎉 Plenamente Logrado', value: 'PL' },
    { label: '😎 Logrado', value: 'L' },
    { label: '🛠️ En Proceso', value: 'EP' },
    { label: '🔄 Por Mejorar', value: 'PM' },
    { label: '❌ Sin Lograr', value: 'NL' }
];

const props = defineProps<{
    DailyClass: Indicator,
    students: Student[],
    allNote: {
        itemIvaluationId: number;
        studentId: number;
        note: string;
    }[],
}>()

// const props = defineProps({
//     DailyClass: {
//         type: Object as () => {
//             indicators: { id: number; title: string }[];
//         },
//         required: true,
//     },
//     students: {
//         type: Array as () => {
//             id: number;
//             name: string;
//             surname: string;
//             grade?: { [key: number]: string };
//         }[],
//         required: true,
//     },
//     allNote: {
//         type: Array as () => {
//             itemIvaluationId: number;
//             studentId: number;
//             note: string;
//         }[],
//         default: () => [],
//     }
// });

// Usamos ref para crear un estado reactivo para los estudiantes.
const studentsWithGrades = ref([]);

// Usamos watchEffect para inicializar el estado local cuando las props cambian.
watchEffect(() => {
    if (props.students.length > 0 && props.DailyClass?.indicators) {
        // Primero, creamos una copia de los estudiantes con una estructura de grados inicial.
        const students = props.students.map(student => {
            const initialDegree = props.DailyClass.indicators.reduce((acc, indicator) => {
                acc[indicator.id] = '';
                return acc;
            }, {});

            return {
                ...student,
                grade: { ...initialDegree, ...(student.grade || {}) },
            };
        });

        // Luego, si hay notas en la prop allNote, las aplicamos a los estudiantes.
        if (props.allNote?.length > 0) {
            props.allNote.forEach(note => {
                const studentToUpdate = students.find(s => s.id === note.studentId);
                if (studentToUpdate) {
                    studentToUpdate.grade[note.itemEvaluationId] = note.note;
                }
            });
        }

        // Asignamos el resultado final al estado reactivo.
        studentsWithGrades.value = students;
    }
});

// Propiedad computada para calcular el progreso de calificación de un estudiante.
const studentProgress = computed(() => (student) => {
    // Si el estudiante no tiene grados, el progreso es 0.
    if (!student.grade) return 0;

    const totalIndicators = props.DailyClass.indicators.length;
    // Filtramos los grados que no son cadenas vacías para contar los calificados.
    const gradedCount = Object.values(student.grade).filter(grade => grade !== '').length;

    // Calculamos el porcentaje de progreso.
    return totalIndicators > 0 ? (gradedCount / totalIndicators) * 100 : 0;
});

// Propiedad computada para determinar si un estudiante ha sido calificado completamente.
const isFullyGraded = computed(() => (student) => {
    // Compara el número de indicadores calificados con el total.
    return studentProgress.value(student) === 100;
});

// Función para guardar la calificación de un indicador específico.
const saveGrade = (student, indicator) => {
    // Enviamos el post request con los datos correctos

    router.post('/teacher/evaluate/class/save', {
        studentId: student.id,
        evaluationId: props.DailyClass.id,
        indicatorId: indicator.id,
        note: student.grade[indicator.id],
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['students', 'DailyClass', 'allNote']
    });

};
</script>
