<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { BreadcrumbItem } from '@/types';
import { Pagination } from '@/types/dtos';
import { Representative } from '@/types/dtos';
import ListRepresntaiveTable from './Components/ListRepresentaiveTable.vue';

const props = defineProps<{
    representatives: Pagination<Representative>
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lista de representates',
        href: '/representative/index'
    }
]
</script>

<template>

    <Head title="Lista de representates" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Heading title="Lista de representantes" />
        <ListRepresntaiveTable :representatives="props.representatives" />
    </AppLayout>
</template>