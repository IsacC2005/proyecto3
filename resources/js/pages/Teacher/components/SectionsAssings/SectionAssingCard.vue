<template>
    <div
        class="bg-gradient-to-br from-emerald-300 to-blue-100 relative rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out cursor-pointer group">
        <div class="group absolute top-10 left-0 flex items-center justify-start p-6 md:p-2 opacity-10 md:opacity-15">
            <p
                class="text-9xl md:text-8xl lg:text-9xl font-black text-chart-2 group-hover:rotate-4 transition-all duration-300 ease-in-out">
                {{ props.section.section.toString().toUpperCase() }}
            </p>
        </div>

        <div
            class="absolute top-0 right-0 w-4/5 h-full flex flex-col items-end justify-between p-4 md:p-2 text-right z-10">
            <div class="flex items-center space-x-4">
                <p class="text-sm font-semibold text-gray-700 mb-0 ">
                    {{ props.section.schoolYear }}
                </p>
                <SectionGrade :grade="props.section.grade"></SectionGrade>
            </div>

            <SectionAssingLearningProject :learningProject="props.section.learningProject"
                :enrollment-id="props.section.id" :teacher-id="props.section.teacher?.id">
            </SectionAssingLearningProject>
        </div>

        <div class="w-full flex items-end">


        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Section } from '@/types/dtos';
import SectionGrade from '@/pages/Enrollment/components/Section/SectionGrade.vue';
import SectionAssingLearningProject from './SectionAssingLearningProject.vue';

const props = defineProps<{
    section: Section
}>()


</script>
