<script setup lang="ts">

const props = defineProps<{
    connectionStatus: string
    connectionMessage: string
}>()
</script>


<template>
    <div class="mt-6 p-4 text-center rounded-lg" :class="{
        'bg-gray-100 text-gray-600': props.connectionStatus === 'idle',
        'bg-yellow-100 text-yellow-700': props.connectionStatus === 'testing',
        'bg-green-100 text-green-700': props.connectionStatus === 'success',
        'bg-red-100 text-red-700': props.connectionStatus === 'error',
    }">
        <p class="font-medium">
            {{ props.connectionMessage }}
        </p>
    </div>
</template>