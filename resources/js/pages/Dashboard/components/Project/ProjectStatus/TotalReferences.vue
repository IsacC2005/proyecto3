<template>
    <div
        class="p-6 rounded-xl border border-[--border] shadow-sm shadow-green-400 bg-background flex flex-col justify-between transition-transform duration-300 hover:scale-[1.02]">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-[--muted-foreground]">Clases Totales</p>
            <svg class="h-4 w-4 text-[--muted-foreground]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5z"></path>
            </svg>
        </div>
        <div class="text-3xl font-bold text-[--foreground] mt-2">{{ props.totalClasses }}
        </div>
    </div>
</template>

<script setup lang="ts">
const props = defineProps({
    totalClasses: {
        type: Number,
        required: true
    }
});
</script>