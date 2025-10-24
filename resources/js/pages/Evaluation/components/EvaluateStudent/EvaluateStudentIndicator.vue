<template>
    <span class="text-base font-medium text-gray-600">{{ indicator.title }}</span>
    <div>
        <select :id="'grade-select-' + props.studentId + '-' + indicator.id" v-model="noteSelect"
            @change="evaluateStore.saveNote(props.studentId, indicator.id, noteSelect), emit('note-changed', noteSelect)"
            class="mt-1 block text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <option value="" disabled>-- Selecciona --</option>
            <option v-for="gradeOption in gradeOptions" :key="gradeOption.value" :value="gradeOption.value">
                {{ gradeOption.label }}
            </option>
        </select>
    </div>
</template>

<script setup lang="ts">
import { useEvaluateStore } from '@/store/EvaluteReferentStore';
import { Indicator } from '@/types/dtos';
import { onMounted, ref } from 'vue';
import { noteValue } from '@/store/EvaluteReferentStore';

const evaluateStore = useEvaluateStore();

const noteSelect = ref('' as noteValue);

const emit = defineEmits<{
    (e: 'note-changed', value: noteValue): void
}>()

const props = defineProps<{
    studentId: number,
    indicator: Indicator,
    noteProp: noteValue
}>()

onMounted(() => {
    noteSelect.value = props.noteProp ?? '';
})

const gradeOptions = [
    { label: '🚀🎉 Plenamente Logrado', value: 'PL' },
    { label: '😎 Logrado', value: 'L' },
    { label: '🛠️ En Proceso', value: 'EP' },
    { label: '🔄 Por Mejorar', value: 'PM' },
    { label: '❌ Sin Lograr', value: 'SL' }
];
</script>