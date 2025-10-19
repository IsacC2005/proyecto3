<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import ContentPage from '@/components/ContentPage.vue';
import StudentCard from './components/StudentCard.vue';
import StudentName from './components/StudentName.vue';
import QualitiesType from './components/Qualities/QualitiesType.vue';
import StudentEvaluateStatus from './components/StudentEvaluateStatus.vue';

import { Student } from '@/types/dtos';
import { qualitiesType } from '@/store/QualitiesStore';

// Definiciones de tipos (dejamos el código limpio)


const props = defineProps<{
    learningProjectId: number,
    students: Student[],
    qualities: qualitiesType[],
    allNote: Record<number, number[]>
    allEvaluatedStatus: Record<number, boolean>
}>()
</script>

<template>
    <AppLayout>

        <Heading title="Evaluación Rápida de Cualidades" />
        <ContentPage>

            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Selecciona un Estudiante para Evaluar</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template v-for="student in props.students" :key="student.id">
                    <StudentCard>

                        <StudentName :name="`${student.name} ${student.surname}`" />
                        <QualitiesType :qualities="props.qualities" :student-id="student.id"
                            :learning-project-id="props.learningProjectId" :studentQualitieIds="allNote[student.id]" />
                        <StudentEvaluateStatus :studentId="student.id" :learningProjectId="props.learningProjectId"
                            :is-evaluated="props.allEvaluatedStatus[student.id] || false" />
                    </StudentCard>
                </template>
            </div>
        </ContentPage>
    </AppLayout>
</template>
