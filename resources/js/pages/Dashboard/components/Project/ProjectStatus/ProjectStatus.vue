<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">

        <total-references :total-classes="props.totalCLasses"></total-references>
        <total-references-evaluate :total-classes-evaluate="props.totalClassesEvaluate"></total-references-evaluate>


        <div
            class="p-6 rounded-xl border border-[--border] shadow-sm bg-[--card] flex flex-col justify-between transition-transform duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-[--muted-foreground]">Progreso General</p>
                <svg class="h-4 w-4 text-[--muted-foreground]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12.55a11 11 0 1 0 14.23-.42"></path>
                </svg>
            </div>
            <div class="text-3xl font-bold text-[--foreground] mt-2">{{ completionPercentage }}%</div>
        </div>
    </div>
</template>

<script setup lang="ts">

import TotalReferences from './TotalReferences.vue';
import TotalReferencesEvaluate from './TotalReferencesEvaluate.vue';

const props = defineProps({
    totalCLasses: {
        type: Number,
        required: true
    },
    totalClassesEvaluate: {
        type: Number,
        required: true
    }
})

</script>