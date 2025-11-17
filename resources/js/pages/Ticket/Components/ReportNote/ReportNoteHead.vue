<script setup lang="ts">

const props = defineProps<{
    name: string
    average: string
}>()

const getAverageStyles = (average: string): string => {
    const base = "font-bold text-sm px-3 py-1 rounded-full inline-block whitespace-nowrap";
    switch (average) {
        case 'A': return `${base} bg-green-100 text-green-700`;
        case 'B': return `${base} bg-yellow-100 text-yellow-700`;
        default: return `${base} bg-gray-100 text-gray-700`;
    }
}
</script>

<template>
    <div class="flex justify-between items-start mb-4 border-b pb-3">
        <h3 class="text-lg font-extrabold text-gray-800 leading-tight">
            {{ props.name }}
        </h3>
        <span :class="getAverageStyles(props.average)">
            Literal: {{ props.average }}
        </span>
    </div>
</template>