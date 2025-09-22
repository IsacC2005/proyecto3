<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" :class="{ 'max-w-xs mx-auto': isMobile }">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-card-foreground uppercase bg-card dark:bg-card dark:text-gray-400">
                <tr>
                    <th v-for="header in props.headers" scope="row" :key="header"
                        class="px-6 py-4 font-medium text-[1rem] text-foreground whitespace-nowrap">
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <TableRow v-for="(item, index) in props.items" :key="index">
                    <slot name="body" :item="item"></slot>
                </TableRow>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts" generic="T">
import { ref, onMounted } from 'vue';
import TableRow from './TableRow.vue';

type HeaderTable = string[];

const props = defineProps<{
    headers: HeaderTable,
    items: T[]
}>();

const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth <= 640;
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});
</script>
