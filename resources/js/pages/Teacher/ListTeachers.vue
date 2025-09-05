<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Heading :title="`Lista de profesores`"></Heading>
        <TableTeacher :pagination="props.teachers">

        </TableTeacher>

        <Paginator :pages="teachers.links" />
    </AppLayout>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import Paginator from '@/components/Paginator.vue';
import TableTeacher from './components/TableTeachers/TableTeacher.vue';
import Heading from '@/components/Heading.vue';
import { Pagination, Teacher } from '@/types/dtos';
import { BreadcrumbItem } from '@/types';


const props = defineProps<{
    teachers: Pagination<Teacher>
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lista de profesores',
        href: '/teacher/index'
    }
]
</script>
