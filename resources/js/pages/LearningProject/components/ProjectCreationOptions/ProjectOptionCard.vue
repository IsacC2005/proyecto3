<template>
    <div class="bg-white p-6 rounded-lg shadow-md border-t-4" :class="disabled ? 'border-gray-300' : 'border-blue-600'">
        <h3 class="text-xl font-semibold mb-2">{{ title }}</h3>
        <p class="text-gray-600 mb-4">{{ description }}</p>

        <slot />
    </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

defineProps({
    title: { type: String, required: true },
    description: { type: String, required: true },
    buttonText: { type: String, default: 'Crear Proyecto' },
    disabled: { type: Boolean, default: false },
});

defineEmits(['create']);
</script>