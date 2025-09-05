<template>
    <nav class="flex justify-center my-8">
        <ul class="flex items-center space-x-2 text-sm font-medium">
            <template v-for="page in pages" :key="page.label">
                <li v-if="page.url === null">
                    <span
                        class="flex items-center justify-center px-4 py-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed dark:bg-gray-700 dark:text-gray-500"
                        v-html="page.label"></span>
                </li>

                <li v-else-if="page.active">
                    <Link
                        class="flex items-center justify-center px-4 py-2 text-white bg-blue-600 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        :href="page.url" v-html="page.label" />
                </li>

                <li v-else>
                    <Link
                        class="flex items-center justify-center px-4 py-2 text-gray-700 bg-white rounded-md shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors duration-200"
                        :href="page.url" v-html="page.label" />
                </li>
            </template>
        </ul>
    </nav>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    pages: {
        type: Array,
        required: true
    }
});
</script>
