<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Project from './components/Project/Project.vue';
import { LearningProject } from '@/types/dtos';
import { usePage } from '@inertiajs/vue3';
import Welcome from './components/Welcome.vue';

const page = usePage();

const props = defineProps<{
    data: {
        project: LearningProject,
        evaluateClasses: number
    }
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="props.data.project" class="px-10 pt-5">
            <Project :project="props.data.project"></Project>
        </div>
        <div v-else>
            <Welcome></Welcome>
        </div>
        {{ props.data.evaluateClasses }}
    </AppLayout>
</template>