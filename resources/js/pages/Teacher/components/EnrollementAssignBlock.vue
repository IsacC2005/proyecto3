<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Heading :title="`Matriculas del periodo escolar ${props.sections[0].schoolYear}`" />
        <div class="p-2 sm:p-4 md:p-6">
            <GridSections :sections="sections" />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Section } from '@/types/dtos';
import SectionCard from '@/pages/Enrollment/components/Section/SectionCard.vue';

const props = defineProps<{
    sections: Section
}>()
</script>