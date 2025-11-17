<script setup lang="ts">
import { onMounted } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAllNoteStore } from '@/store/AllNoteStore';
import TableNotes from './components/TableNotes/TableNotes.vue';
import Heading from '@/components/Heading.vue';
import { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const dataStore = useAllNoteStore();

interface Student {
    id: number;
    name: string
    notesByReferent: []
}


interface Referent {
    id: number;
    title: string;
    indicators: Indicator[]
}

interface Indicator {
    id: number;
    name: string;
}

interface Props {
    data: {
        projectId: number;
        classes: Referent[];
        students: Student[];
    };
}

const props = defineProps<Props>();


onMounted(() => {
    dataStore.projectId = props.data.projectId;
    dataStore.referents = props.data.classes;
    dataStore.notes = props.data.students;
});
const downloadUrl = `/learning-project/download-notes?projectId=${props.data.projectId}`;
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Lista de proyectos',
        href: '/learning-project/index',
    },
    {
        title: 'Proyecto',
        href: '/learning-project/show/' + props.data.projectId,
    },
    {
        title: 'Resumen de calificaciones',
        href: '/learning-project/notes/',
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Resumen de calificaciones" />
        <Heading title="Resumen de calificaciones del proyecto " />
        <div class="px-4 py-4 md:px-6 flex justify-end">

            <a :href="downloadUrl" class="
                inline-flex items-center px-4 py-2 border border-transparent 
                text-sm font-medium rounded-md shadow-sm text-white        bg-indigo-600 hover:bg-indigo-700        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                transition ease-in-out duration-150 ">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">

                    <path fill-rule="evenodd"
                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd" />

                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v7a1 1 0 11-2 0V3a1 1 0 011-1z" clip-rule="evenodd" />

                </svg>
                Descargar Notas
            </a>

        </div>
        <div class="px-4">
            <TableNotes />
        </div>

    </AppLayout>
</template>



<style scoped>
.sticky-col-student {
    position: sticky;
    left: 0;
    z-index: 10;
    background-color: #f9fafb;
    border-right: 1px solid #e5e7eb;
}
</style>