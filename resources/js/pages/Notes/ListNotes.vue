<template>
    <AppLayout>
        <Heading title="Resumen de calificaciones del proyecto " />
        <div class="px-4">
            <TableNotes />
        </div>

    </AppLayout>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAllNoteStore } from '@/store/AllNoteStore';
import TableNotes from './components/TableNotes/TableNotes.vue';
import Heading from '@/components/Heading.vue';

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
</script>

<style scoped>
.sticky-col-student {
    position: sticky;
    left: 0;
    z-index: 10;
    background-color: #f9fafb;
    border-right: 1px solid #e5e7eb;
}
</style>