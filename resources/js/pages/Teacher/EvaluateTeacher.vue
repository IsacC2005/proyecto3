<template>
    <AppLayout>
        <ul v-for="evaluation in evaluations"
            class="w-full flex flex-wrap items-center gap-4 text-sm font-medium text-gray-500 dark:text-gray-400">
            <Evaluation :id="evaluation.id" :name="evaluation.title"></Evaluation>
        </ul>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Evaluation from './components/Evaluation.vue';
import { defineProps } from 'vue';

const props = defineProps({
    evaluations: {
        type: Array,
        required: true
    }
})

</script>
