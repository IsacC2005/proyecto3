<template>
    <div class="pb-4 border-b border-[--border]">
        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-[--foreground]">
            {{ props.title }}
        </h1>
        <p class="mt-1 text-base text-[--muted-foreground]">¡Tu progreso en el proyecto Full Stack!</p>
    </div>
</template>

<script setup lang="ts">

const props = defineProps({
    title: {
        type: String,
        required: true
    }
});
</script>