<template>
    <AppLayout>
        <div class="p-6 md:p-6 bg-background min-h-screen">
            <h1 class="text-3xl md:text-5xl font-extrabold text-center text-gray-800 mb-8 md:mb-12 drop-shadow-md">
                {{ props.message }}</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 justify-items-center">

            </div>
            <GridSections :sections="sections"></GridSections>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import SectionCard from './components/Section/SectionCard.vue';
import { Enrollment } from '@/types';
import GridSections from './components/GridSections.vue';


const props = defineProps({
    sections: {
        type: Array as () => Enrollment[],
        required: true
    },
    message: {
        type: String,
        required: true
    }
});
</script>
