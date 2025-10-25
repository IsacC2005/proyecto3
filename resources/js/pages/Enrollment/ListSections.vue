<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps, ref, watch } from 'vue';
import { BreadcrumbItem } from '@/types';
import GridSections from './components/GridSections.vue';
import { Section } from '@/types/dtos';
import Heading from '@/components/Heading.vue';
import FilterBox from './components/FilterBox/FilterBox.vue';


const filtered = ref();

watch(filtered, () => {
    console.log(filtered.value)
})

const props = defineProps({
    sections: {
        type: Array as () => Section[],
        required: true
    },
    schoolYear: {
        type: String,
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

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Heading :title="`Matriculas del periodo escolar ${props.schoolYear}`" />

        <FilterBox @filtered="filtered = $event" :sections="props.sections" :schoolYear="props.schoolYear" />
        <div class="p-2 sm:p-4 md:p-6">
            <GridSections :sections="filtered" />
        </div>
    </AppLayout>
</template>
