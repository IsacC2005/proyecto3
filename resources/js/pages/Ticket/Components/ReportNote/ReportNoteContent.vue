<script setup lang="ts">

const props = defineProps<{ content: string }>()

/**
 * @param text
 * @param limit
 * @returns
 */
const truncateText = (text: string, limit: number = 200): string => {
    if (!text) return "";
    return text.length > limit ? text.substring(0, limit) + "..." : text;
};
</script>

<template>
    <div class="flex-grow mb-4">
        <p class="text-sm text-gray-600 line-clamp-4">
            {{ truncateText(props.content, 200) }}
        </p>
    </div>
</template>