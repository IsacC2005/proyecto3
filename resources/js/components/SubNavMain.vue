<script setup lang="js">
import { Link } from '@inertiajs/vue3';

// Los props que recibe del componente padre
const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <ul class="flex flex-col gap-0.5 border border-accent mt-2 ml-4 rounded">
        <li class="p-1  rounded hover:bg-accent" v-for="subitem in items" :key="subitem.title">
            <Link :href="subitem.href" class="ml-4">
            <span class="font-sans text-sm">{{ subitem.title }}</span>
            </Link>
        </li>
    </ul>
</template>
