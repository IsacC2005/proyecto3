<template>
    <div
        class="px-4 py-2 bg-white/30 backdrop-blur-sm rounded-md shadow-inner text-foreground font-semibold flex flex-col items-end">
        <p class="text-sm md:text-base">Profesor</p>
        <p v-if="props.section.teacher" class="text-[0.63rem] text-gray-700 font-normal truncate max-w-[120px]">
            {{ `${props.section.teacher.name} ${props.section.teacher.surname}` }}
        </p>
        <div v-else class="mt-1">
            <a href="https://sigesin.japeco.com/" target="_blank"
                class="px-2 py-1 text-center bg-blue-700 text-white text-xs md:text-sm font-bold rounded-full hover:bg-blue-800 transition-colors duration-200">
                Asignar
            </a>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Section } from '@/types/dtos';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    section: Section
}>()
</script>
