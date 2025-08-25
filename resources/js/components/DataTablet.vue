<template>


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" :class="{ 'max-w-xs mx-auto': isMobile }">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-card-foreground uppercase bg-card dark:bg-card dark:text-gray-400">
                <tr>
                    <th v-for="header in headers" scope="row"
                        class="px-6 py-4 font-medium text-[1rem] text-foreground whitespace-nowrap">
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-background hover:bg-accent border-b-[1px] border-b-border transition-colors duration-300 ease-out"
                    v-for="item in items">
                    <slot name="body" :item="item"></slot>
                </tr>
            </tbody>
        </table>
    </div>


</template>

<script setup lang="ts">
import { defineProps } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
    headers: {
        type: Array,
        required: true,
    },
});

import { ref, computed, onMounted } from 'vue';

const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth <= 640;
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});
</script>
