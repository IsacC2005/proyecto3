<template>
    <div
        class="bg-gradient-to-br from-emerald-300 to-blue-100 dark:from-emerald-900 dark:to-emerald-700 relative rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out cursor-pointer group">
        <SectionButtonUpdate :enrollmentId="props.section.id"></SectionButtonUpdate>
        <div class="group absolute top-10 left-0 flex items-center justify-start p-6 md:p-2 opacity-10 md:opacity-15">
            <p
                class="text-9xl md:text-8xl lg:text-9xl font-black text-chart-2 group-hover:rotate-4 transition-all duration-300 ease-in-out">
                {{ props.section.section.toString().toUpperCase() }}
            </p>
        </div>

        <div
            class="absolute top-0 right-0 w-1/2 h-full flex flex-col items-end justify-between p-4 md:p-2 text-right z-10">
            <SectionGrade :grade="props.section.grade"></SectionGrade>

            <SectionDetail :section="props.section"></SectionDetail>
        </div>

        <SectionLearningProject v-if="props.section.learningProject" :learning-project="props.section.learningProject">
        </SectionLearningProject>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Section } from '@/types/dtos';
import SectionGrade from './SectionGrade.vue';
import SectionDetail from './SectionDetail.vue';
import SectionLearningProject from './SectionLearningProject.vue';
import SectionButtonUpdate from './SectionButtonUpdate.vue';

const props = defineProps<{
    section: Section
}>()


</script>
