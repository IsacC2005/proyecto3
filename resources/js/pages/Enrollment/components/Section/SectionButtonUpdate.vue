<template>
    <button @click="action" class="p-2 rounded-full bg-blue-300 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50
        transition duration-300 ease-in-out group" aria-label="Editar registro">
        <svg class="w-5 h-5 text-gray-600 group-hover:text-blue-700 transition duration-300 ease-in-out"
            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
        </svg>
    </button>
</template>

<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3';


const props = defineProps({
    enrollmentId: {
        type: Number,
        required: true
    }
})

const action = () => {
    router.get(`/enrollment/edit/${props.enrollmentId}`);
}

</script>
