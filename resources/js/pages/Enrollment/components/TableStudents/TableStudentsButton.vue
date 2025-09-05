<template>
    <div v-if="!addSection">
        <button type="button" @click="submit()"
            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200"
            :class="{ 'opacity-50 cursor-not-allowed': form.processing }" :disabled="form.processing">
            <template v-if="form.processing">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Agregando...
            </template>
            <template v-else>
                Agregar
            </template>
        </button>
    </div>
    <div v-else
        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-500 cursor-not-allowed transition-all duration-200">
        <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        Ya Agregado
    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    enrollmentId: {
        type: Number,
        required: true
    },
    studentId: {
        type: Number,
        required: true
    },
    addSection: {
        type: Boolean,
        required: true
    }
});

const form = useForm({
    enrollmentId: props.enrollmentId,
    studentId: props.studentId
});

const submit = () => {
    form.post(route('enrollment.add-student'), {
        preserveScroll: true,
        preserveState: true
    });
};
</script>
