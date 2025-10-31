<template>
    <EvaluateStudentCard :status="status">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-700 truncate">{{ props.student.name + " " + student.surname
                }}</h2>
            <div class="w-24 bg-gray-200 rounded-full h-2.5">
                <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300 ease-in-out"
                    :style="'width:' + studentProgress + '%'"></div>
            </div>
        </div>

        <div v-for="indicator in referent?.indicators" :key="indicator.id"
            class="w-full flex flex-col items-start lg:flex-row lg:items-center px-2 gap-x-4 border rounded mb-2">
            <EvaluateStudentIndicator :studentId="props.student.id" :indicator='indicator'
                :noteProp='notes ? notes[props.student.id]?.[indicator.id] ?? "" : ""' />
        </div>
    </EvaluateStudentCard>
</template>

<script setup lang="ts">
import { Student } from '@/types/dtos';
import EvaluateStudentCard from './EvaluateStudentCard.vue';
import EvaluateStudentIndicator from './EvaluateStudentIndicator.vue';
import { storeToRefs } from 'pinia';
import { Notes, useEvaluateStore } from '@/store/EvaluteReferentStore';
import { computed, ref, watch } from 'vue';
import { noteValue } from '@/store/EvaluteReferentStore';

const EvaluationStore = useEvaluateStore();

const { referent, notes } = storeToRefs(EvaluationStore);

const props = defineProps<{
    student: Student
}>();

const status = ref('' as noteValue);

const studentNotes = computed(() => {
    return notes.value ? notes.value[props.student.id] ?? {} : {};
});



const updateStatus = (newNotes: Notes) => {
    const totalIndicators = referent.value?.indicators.length || 0;
    const totalPL = Object.values(newNotes).filter(note => note === 'PL').length;
    const totalNL = Object.values(newNotes).filter(note => note === 'SL').length;
    const totalNotes = Object.values(newNotes).length;

    if (totalNotes === 0) {
        status.value = '';
    } else if (totalPL === totalIndicators && totalIndicators > 0) {
        status.value = 'PL';
    } else if (totalNL === totalIndicators && totalIndicators > 0) {
        status.value = 'SL';
    } else if (totalNotes === totalIndicators) {
        status.value = 'L';
    } else {
        status.value = ''
    }

    studentProgress.value = totalNotes > 0 ? (totalNotes / totalIndicators) * 100 : 0
}

const studentProgress = ref(0);

watch(studentNotes,
    (newNotes: Notes) => {
        updateStatus(newNotes)
    },
    {
        deep: true,
        immediate: true
    });
</script>