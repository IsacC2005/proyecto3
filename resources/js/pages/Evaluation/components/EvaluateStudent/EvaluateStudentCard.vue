<script setup lang="ts">
import { noteValue } from '@/store/EvaluteReferentStore';

const props = defineProps<{
    status: noteValue
}>()

const bg = () => {
    if (props.status === 'PL') {
        return 'bg-gradient-to-r from-green-100 to-green-300 border border-green-100';
    } else if (props.status === 'L' || props.status === 'EP' || props.status === 'PM') {
        return 'bg-green-100';
    } else if (props.status === 'SL') {
        return 'bg-red-100';
    } else if (props.status === '') {
        return 'bg-background';
    } else {
        return '';
    }
}
</script>

<template>
    <div class="rounded-lg shadow-md p-6 transform transition-transform duration-300 hover:scale-105"
        :class="{ [bg()]: true }">
        <slot />
    </div>
</template>
