<template>
    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del
            Referente Teórico <span class="text-red-500">*</span></label>
        <input type="text" id="title" v-model="data.form.title" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    </div>
</template>

<script setup lang="ts">
import { useReferenStore } from '@/store/ReferentStore';
const data = useReferenStore();
</script>