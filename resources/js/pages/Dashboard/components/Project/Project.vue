<template>
    <div class="p-4 sm:p-6 lg:p-8 space-y-8">
        <project-heading :title="props.project.title" />
        <project-status :total-c-lasses="10" :total-classes-evaluate="1"></project-status>


        <div class="p-6 rounded-xl border border-[--border] shadow-sm bg-[--card]">
            <h2 class="text-lg font-semibold mb-4 text-[--foreground]">Progreso por Clase</h2>
            <ul class="space-y-4">
                <li v-for="classDetail in project.dailyClasses" :key="classDetail.title">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-[--foreground]">{{ classDetail.title }}</span>
                        <span class="text-sm font-bold text-[--foreground]">{{ (10 /
                            12 * 100).toFixed(0) }}%</span>
                    </div>
                    <div class="mt-1 w-full h-2 rounded-full bg-[--input]">
                        <div class="h-full rounded-full transition-all duration-700 ease-out"
                            :class="{ 'bg-[--primary]': true }" :style="{ width: (10 / 20 * 100).toFixed(0) + '%' }">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { LearningProject } from '@/types/dtos';
import ProjectHeading from './ProjectHeading.vue';
import ProjectStatus from './ProjectStatus/ProjectStatus.vue';

const props = defineProps<{
    project: LearningProject
}>()

const completionPercentage = computed(() => {
    const totalEvaluated = projectData.value.class_data.evaluated_classes;
    const totalClasses = projectData.value.class_data.total_classes;
    if (totalClasses === 0) return 0;
    return ((totalEvaluated / totalClasses) * 100).toFixed(0);
});
</script>