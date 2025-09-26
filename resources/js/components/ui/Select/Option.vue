<script setup lang="ts">
import { MenuItem } from '@headlessui/vue';

const emit = defineEmits(['click']);
</script>

<template>
    <MenuItem>
    <button @click="emit('click')" class="
        'block w-full text-left px-4 py-2 text-sm">
        <slot />
    </button>
    </MenuItem>
</template>