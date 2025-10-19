<script setup lang="ts">
const props = defineProps({
    name: {
        type: String,
        required: true
    }
})
</script>

<template>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700 truncate">{{
            props.name
        }}</h2>
    </div>
</template>