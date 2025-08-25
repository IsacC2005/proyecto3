<template>
    <li>
        <Link href="/teacher/evaluate/class" :data="{ class_id: props.id }"
            class="flex flex-grow items-center justify-center px-4 py-3 bg-blue-700 rounded-lg text-white dark:bg-blue-600"
            aria-current="page">
        <svg class="w-4 h-4 me-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
        </svg>
        {{ props.name }}
        </Link>
    </li>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    id: {
        type: Number,
        required: true,
        default: 0
    },
    name: {
        type: String,
        required: true,
        default: ''
    },
    link: {
        type: String,
        required: true,
        default: '#'
    }

})
</script>
