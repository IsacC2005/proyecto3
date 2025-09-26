<template>
    <div v-if="props.sections?.length > 0" class="flex flex-wrap gap-6">
        <SectionCard v-for="(section, index) in props.sections" :key="index" :section="section"
            class="min-h-60 min-w-75 grow-120 box-content">
        </SectionCard>
    </div>
</template>

<script setup lang="ts">
import { Section } from '@/types/dtos';
import { defineProps } from 'vue';
import SectionCard from './Section/SectionCard.vue';
const props = defineProps<{
    sections: Section[]
}>()
</script>
