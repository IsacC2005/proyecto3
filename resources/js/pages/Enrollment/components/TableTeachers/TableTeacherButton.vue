<template>
    <button @click="assign"
        class="text-foreground border border-muted-foreground hover:text-background hover:bg-foreground font-medium rounded-lg text-sm px-4 py-2 text-center me-2 mb-2 flex items-center gap-2 transition-colors duration-150 group">
        <svg class="w-5 h-5 transition-colors duration-150 text-foreground group-hover:text-background"
            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <template v-if="form.processing">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            Asignando...
        </template>
        <template v-else>
            Asignar
        </template>
    </button>
</template>

<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';


const props = defineProps<{
    enrollmentId: number,
    teacherId: number
}>()

const form = useForm({
    enrollmentId: props.enrollmentId,
    teacherId: props.teacherId
})

const assign = () => {
    form.post(route('enrollment.assign-teacher'));
}
</script>
