<template>
    <div
        class="p-6 rounded-xl border border-[--border] shadow-sm bg-[--card] flex flex-col justify-between transition-transform duration-300 hover:scale-[1.02]">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-[--muted-foreground]">Clases Evaluadas</p>
            <svg class="h-4 w-4 text-[--muted-foreground]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        <div class="text-3xl font-bold text-[--foreground] mt-2">{{ props.totalClassesEvaluate }}
        </div>
    </div>
</template>

<script setup lang="ts">

const props = defineProps({
    totalClassesEvaluate: {
        type: Number,
        required: true
    }
});
</script>