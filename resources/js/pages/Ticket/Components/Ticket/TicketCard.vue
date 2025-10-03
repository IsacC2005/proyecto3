<script setup lang="ts">

const emit = defineEmits(['click'])
</script>

<template>
    <div class="border border-muted-foreground rounded-sm p-4 mb-4 cursor-pointer transition-all ease-in-out duration-200 bg-background
                hover:shadow-md hover:scale-105 " @click="emit('click')">
        <slot />
    </div>
</template>