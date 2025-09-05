<template>
    <div class="flex flex-wrap gap-6">
        <SectionAssingCard v-for="section in props.sections" :key="section.id" :section="section"
            class="min-h-60 min-w-75 grow-120 box-content">
        </SectionAssingCard>
    </div>
</template>

<script setup lang="ts">
import { Section } from '@/types/dtos';
import { defineProps } from 'vue';
import SectionAssingCard from './SectionsAssings/SectionAssingCard.vue';

const props = defineProps<{ sections: Section[] }>()

</script>