<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import AppContent from '@/components/AppContent.vue';
import TakeStudent from './Components/TakeStudent.vue';
import { Student } from '@/types/dtos';
import { useForm } from '@inertiajs/vue3';
import { useAttendanceStore } from '@/store/AttendanceStore';
import { storeToRefs } from 'pinia';

const props = defineProps<{
    projectId: number
    students: Student[]
}>();

const data = useAttendanceStore()

onMounted(() => {
    data.form.projectId = props.projectId
})

const form = useForm({
    projectId: 0,
    studentId: 0
});

// Define TRES estados posibles para la asistencia.
type AttendanceStatus = 'present' | 'absent' | 'pending';

// Objeto reactivo para mantener el estado de la asistencia.
const attendance = ref<Record<number, AttendanceStatus>>({});

// Al montar el componente, inicializa a TODOS los estudiantes como 'pending'.
onMounted(() => {
    props.students.forEach(student => {
        attendance.value[student.id] = 'pending';
    });
});

// Función para cambiar el estado de la asistencia en un ciclo.
// El ciclo de click ahora es: pending -> present -> absent -> pending
const toggleAttendance = (studentId: number) => {

    form.projectId = 1;
    form.studentId = 2440;

    form.post('/attendance/test');

    console.log('Toggling attendance for student:', studentId);
    const currentStatus = attendance.value[studentId];
    if (currentStatus === 'pending') {
        attendance.value[studentId] = 'present';
    } else if (currentStatus === 'present') {
        attendance.value[studentId] = 'absent';
    } else { // currentStatus is 'absent'
        attendance.value[studentId] = 'pending';
    }
};

// Propiedades computadas para el resumen, ahora incluyendo pendientes.
const presentCount = computed(() => Object.values(attendance.value).filter(s => s === 'present').length);
const absentCount = computed(() => Object.values(attendance.value).filter(s => s === 'absent').length);
const pendingCount = computed(() => Object.values(attendance.value).filter(s => s === 'pending').length);

</script>

<template>
    <AppLayout>
        <Heading title="Tomar asistencia" />
        <AppContent>
            <h1>error {{ form.errors.projectId }} {{ form.errors.studnetId }}</h1>
            <!-- Lista de Estudiantes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <TakeStudent v-for="student in props.students" :key="student.id" :student="student"
                    @toggleAttendance="toggleAttendance($event)" />

            </div>

            <!-- Resumen de Asistencia -->
            <div class="mt-8 p-4 bg-gray-100 rounded-lg grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div>
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-800">{{ props.students.length }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Presentes</p>
                    <p class="text-2xl font-bold text-green-600">{{ presentCount }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Ausentes</p>
                    <p class="text-2xl font-bold text-red-600">{{ absentCount }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-gray-700">{{ pendingCount }}</p>
                </div>
            </div>
        </AppContent>
    </AppLayout>
</template>