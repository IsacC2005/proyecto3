<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    studentId: number
    projectId: number
}>()

const form = useForm({
    projectId: props.projectId,
    studentId: props.studentId
})

const createReportNote = () => {
    form.get('/tickets/store');
};
</script>


<template>
    <button @click="createReportNote" class="
                        text-foreground
                        border border-muted-foreground
                        hover:text-background hover:bg-foreground
                        font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2
                        inline-flex items-center justify-center
                    " :disabled="form.processing">
        <template v-if="form.processing">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            Procesando...
        </template>
        <template v-else>
            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                </path>
            </svg>
            Boletín
        </template>
    </button>
</template>