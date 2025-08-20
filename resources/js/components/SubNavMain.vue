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
    <transition name="slide-down" appear>
        <ul v-if="items && items.length" class="flex flex-col gap-2 p-2 border border-accent mt-2 ml-4 rounded">
            <li class="rounded hover:bg-accent size-full" :class="{ 'bg-accent': subitem.href === $page.url }"
                v-for="subitem in items" :key="subitem.title">
                <Link :href="subitem.href" preserve-state class="inline-block py-1.5 size-full">
                <component :is="subitem.icon" />
                <span class="font-sans text-sm ml-4">{{ subitem.title }}</span>
                </Link>
            </li>
        </ul>
    </transition>
</template>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-down-enter-from,
.slide-down-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}

.slide-down-enter-to,
.slide-down-leave-from {
    opacity: 1;
    transform: translateY(0);
}
</style>
