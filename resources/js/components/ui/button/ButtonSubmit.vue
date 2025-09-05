<template>
    <button type="submit"
        class="inline-flex flex-row items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200"
        :class="{ 'opacity-50 cursor-not-allowed': processing }" :disabled="processing">
        <div v-if="props.processing">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 inline-block text-white" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span>{{ props.processingText }}</span>
        </div>
        <span v-else>
            {{ props.text }}
        </span>
    </button>
</template>

<script setup lang="ts">

const props = defineProps({
    processing: {
        type: Boolean,
        default: false
    },
    text: {
        type: String,
        defult: 'Enviar'
    },
    processingText: {
        type: String,
        default: 'Enviando...'
    }
});
</script>