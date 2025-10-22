<template>
    <nav class="w-full my-8 flex justify-center ">
        <ul class="max-w-full overflow-auto flex items-center space-x-1 sm:space-x-2 text-sm font-medium">
            <template v-for="(page, index) in props.pages" :key="index">
                <li v-if="page.url === null">
                    <span
                        class="flex items-center justify-center px-2 py-2 sm:px-4 sm:py-2 whitespace-nowrap text-gray-400 bg-gray-100 rounded-md cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">{{
                            showLabel(page.label) }}</span>
                </li>

                <li v-else-if="page.active">
                    <Link
                        class="flex items-center justify-center px-2 py-2 sm:px-4 sm:py-2 whitespace-nowrap text-white bg-blue-600 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        :href="page.url">{{ showLabel(page.label) }}</Link>
                </li>

                <li v-else>
                    <Link
                        class="flex items-center justify-center px-2 py-2 sm:px-4 sm:py-2 whitespace-nowrap text-gray-700 bg-white rounded-md shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors duration-200"
                        :href="page.url">{{ showLabel(page.label) }}</Link>
                </li>
            </template>
        </ul>
    </nav>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

type pagination = {
    url: string | null
    label: string
    active: boolean
}

const props = defineProps<{
    pages: string[]
}>();

const showLabel = (value: string): string => {
    if (value === "pagination.previous") {
        return 'Anterior';
    }
    if (value === "pagination.next") {
        return 'Siguiente';
    }
    return value;

}
</script>
