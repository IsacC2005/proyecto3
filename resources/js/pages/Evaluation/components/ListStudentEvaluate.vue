<template>
    <h1> hola estoy vivo perro</h1>
    <div v-for="student in students" :key="student.id"
        class="bg-background rounded-lg shadow-md p-6 transform transition-transform duration-300 hover:scale-105"
        :class="{ 'bg-green-100': isFullyGraded(student) }">
        <EvaluateStudent :student="student"></EvaluateStudent>
    </div>
</template>

<script setup lang="ts">
import { computed, ref, watchEffect } from 'vue';
import EvaluateStudent from './EvaluateStudent/EvaluateStudent.vue';


const props = defineProps({
    DailyClass: {
        type: Object as () => {
            indicators: { id: number; title: string }[];
        },
        required: true,
    },
    students: {
        type: Array as () => {
            id: number;
            name: string;
            surname: string;
            grade?: { [key: number]: string };
        }[],
        required: true,
    },
    allNote: {
        type: Array as () => {
            itemIvaluationId: number;
            studentId: number;
            note: string;
        }[],
        default: () => [],
    }
});

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

const isFullyGraded = computed(() => (student) => {
    // Compara el número de indicadores calificados con el total.
    return studentProgress.value(student) === 100;
});

const studentProgress = computed(() => (student) => {
    // Si el estudiante no tiene grados, el progreso es 0.
    if (!student.grade) return 0;

    const totalIndicators = props.DailyClass.indicators.length;
    // Filtramos los grados que no son cadenas vacías para contar los calificados.
    const gradedCount = Object.values(student.grade).filter(grade => grade !== '').length;

    // Calculamos el porcentaje de progreso.
    return totalIndicators > 0 ? (gradedCount / totalIndicators) * 100 : 0;
});
</script>