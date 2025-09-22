<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Lista de estudiantes" />
        <Heading title="Lista de estudiantes" />
        <ListStudents :students="props.students" />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import ListStudents from './Components/ListStudents/ListStudents.vue';
import { Pagination, Student } from '@/types/dtos';
import { BreadcrumbItem } from '@/types';


const props = defineProps<{
    students: Pagination<Student>
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lista de estudiantes',
        href: '/students/index'
    }
]
</script>
