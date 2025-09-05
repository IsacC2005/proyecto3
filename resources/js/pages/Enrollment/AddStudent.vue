<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Heading
            :title="`Estudiantes para la Sección '${props.section.section.toUpperCase()}' ${props.section.schoolYear}`"
            :description="` Esta es una lista de todos los estudiantes registrados candidatos para registrarce en esta seccion`">
        </Heading>
        <TableStudents :pagination="props.pagination" :section="props.section"></TableStudents>
    </AppLayout>
</template>

---

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Pagination, Section, Student } from '@/types/dtos';
import TableStudents from './components/TableStudents/TableStudents.vue';
import Heading from '@/components/Heading.vue';
import { BreadcrumbItem } from '@/types';

const props = defineProps<{
    pagination: Pagination<Student>;
    section: Section;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lista de Matriculas',
        href: '/enrollment/index',
    },
    {
        title: 'Agregar estudiante a una matricula',
        href: '#'
    },
];
</script>
