<template>
    <AppLayout>
        <ul v-for="evaluation in evaluations"
            class="p-4 sm:p-6 md:p-8 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-inner">
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
