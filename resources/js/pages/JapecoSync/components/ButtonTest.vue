<script setup lang="ts">

const props = defineProps<{
    connectionStatus: string
}>()

const emit = defineEmits(['click'])
</script>

<template>
    <button @click="emit('click')" :disabled="props.connectionStatus === 'testing'"
        class="flex-1 px-6 py-3 text-indigo-700 bg-indigo-100 font-semibold rounded-lg shadow-md transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-indigo-300 hover:bg-indigo-200 disabled:opacity-75 disabled:cursor-not-allowed">
        <span v-if="connectionStatus === 'testing'">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-700 inline" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            Probando conexión
        </span>
        <span v-else>
            Probar Conexión API Rápida
        </span>
    </button>
</template>