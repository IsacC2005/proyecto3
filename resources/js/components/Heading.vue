<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
}

defineProps<Props>();
</script>

<template>
    <div class="flex flex-col

                p-2  sm:p-8">
        <h1 class="text-3xl md:text-4xl sm:mb-2.5 font-extrabold text-foreground inline-block ">
            {{ title }}</h1>
        <p v-if="description" class="text-sm ml-[1%] w-8/10 text-muted-foreground"
            style="overflow: hidden; text-overflow: ellipsis; white-space: wrap;">
            {{ description }}
        </p>
    </div>
</template>
