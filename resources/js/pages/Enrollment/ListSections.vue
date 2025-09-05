<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Heading :title="`Matriculas del periodo escolar ${props.sections[0].schoolYear}`" />
        <div class="p-2 sm:p-4 md:p-6">
            <GridSections :sections="sections" />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import { BreadcrumbItem } from '@/types';
import GridSections from './components/GridSections.vue';
import { Section } from '@/types/dtos';
import Heading from '@/components/Heading.vue';


const props = defineProps({
    sections: {
        type: Array as () => Section[],
        required: true
    }
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lista de Matriculas',
        href: '/enrollment/index',
    }
];
</script>
