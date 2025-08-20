<template>
    <AppLayout>
        <div class="p-6 md:p-12 bg-background min-h-screen">
            <h1 class="text-3xl md:text-5xl font-extrabold text-center text-gray-800 mb-8 md:mb-12 drop-shadow-md">
                Secciones de Matrícula</h1>
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 justify-items-center">
                <EnrollementBlock :sections="enrollments">

                </EnrollementBlock>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import EnrollementBlock from '../Enrollment/components/EnrollementBlock.vue';


const props = defineProps({
    enrollments: {
        type: Array,
        required: true
    }
});
</script>
