<script setup lang="ts">
import Table from '@/components/Table/Table.vue';
import TableData from '@/components/Table/TableData.vue';
// No necesitamos Paginator ni Pagination si el array no está paginado
import { Student } from '@/types/dtos';
import { computed, onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3'; // Asumo que usas Inertia para navegación/enlaces

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
        ? ['Grado', 'Nombre', 'Apellido', 'Boletín']
        : ['Grado', 'Nombre', 'Apellido', 'Boletín'];
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
                {{ item.grade }}
                <p class="inline-block" v-if="!isMobile">ㅤGrado</p>
            </TableData>

            <TableData>{{ item.name }}</TableData>

            <TableData>{{ item.surname }}</TableData>

            <TableData :key="item.id">
                <Link :href="getBoletinCreationLink(item.id)" class="
                        text-foreground
                        border border-muted-foreground
                        hover:text-background hover:bg-foreground
                        font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2
                        inline-flex items-center justify-center
                    ">
                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Boletín
                </Link>
            </TableData>
        </template>
    </Table>

</template>