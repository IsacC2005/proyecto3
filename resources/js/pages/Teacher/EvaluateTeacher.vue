<template>
    <AppLayout title="Evaluations">
        <Heading title="Clases diarias disponibles"
            :description="`Estas son las clases diarias definidas para el proyecto de aprendizaje ${props.project.title}`">
        </Heading>
        <AddClass :project-id="props.project.id"></AddClass>
        <div class="p-4 sm:p-6 md:p-8 flex flex-wrap gap-6 justify-center">
            <Evaluation v-for="(evaluation, index) in props.evaluations" :key="index" :evaluation="evaluation" />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Evaluation from './components/Evaluation.vue';
import { defineProps } from 'vue';
import { DailyClass } from '@/types/dtos';
import Heading from '@/components/Heading.vue';
import AddClass from '../LearningProject/components/AddClass/AddClass.vue';
import { LearningProject } from '@/types/dtos';

const props = defineProps<{
    evaluations: DailyClass[],
    project: LearningProject
}>();
</script>