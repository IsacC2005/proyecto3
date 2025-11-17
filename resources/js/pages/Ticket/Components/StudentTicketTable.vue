<script setup lang="ts">
import Table from '@/components/Table/Table.vue';
import TableData from '@/components/Table/TableData.vue';
// No necesitamos Paginator ni Pagination si el array no está paginado
import { Student } from '@/types/dtos';
import { computed, onMounted, ref } from 'vue';
import StudentTicketTableButton from './StudentTicketTableButton.vue'
import { Link, useForm } from '@inertiajs/vue3'; // Asumo que usas Inertia para navegación/enlaces


const props = defineProps<{
    students: Student[]; // Array simple de estudiantes (no paginado)
    projectId: number;
}>();

const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth <= 640;
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

const headers = computed(() => {
    // Ajustamos los encabezados para la acción de crear boletín
    return isMobile.value
        ? ['Cedula Escolar', 'Nombre', 'Boletín']
        : ['Cedula Escolar', 'Nombre', 'Boletín'];
});

// Función para el botón de acción
const getBoletinCreationLink = (studentId: number) => {
    // Define la ruta a la página de creación/edición de un boletín individual
    return `/project/${props.projectId}/student/${studentId}/create-boletin`;
};

</script>

<template>
    <Table :items="props.students" :headers="headers">
        <template #body="{ item }">
            <TableData>
                {{ item.schoolId }}
            </TableData>

            <TableData>{{ item.name }}</TableData>

            <TableData :key="item.id">
                <StudentTicketTableButton :projectId="props.projectId" :studentId="item.id" />
            </TableData>
        </template>
    </Table>

</template>