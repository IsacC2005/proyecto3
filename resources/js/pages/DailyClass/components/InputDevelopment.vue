<template>
    <div class="mb-4">
        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Desarrollo</label>
        <textarea id="content" v-model="data.form.content" rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
    </div>
</template>

<script setup lang="ts">
import { useReferenStore } from '@/store/ReferentStore';

const data = useReferenStore();
</script>