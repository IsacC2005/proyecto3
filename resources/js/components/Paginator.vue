<template>
    <nav class="w-full mb-4 mt-4">
        <ul class="w-full inline-flex  -space-x-px text-base h-10">
            <template v-for="page in pages" :key="page.url">
                <div v-if="page.url === null"
                    class="flex flex-grow-2 items-center justify-center px-4 h-10 ms-0 leading-tight rounded-s-lg"
                    v-html="page.label" />

                <Link v-else
                    class="flex flex-grow-1 items-center justify-center px-1 h-10 bg-background border-1 border-muted-foreground"
                    :class="{ 'bg-card-foreground text-background': page.active }" :href="page.url"
                    v-html="page.label" />
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
