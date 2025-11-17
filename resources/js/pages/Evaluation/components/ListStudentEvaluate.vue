<template>
    <template v-for="(student, index) in studentsFilters" :key="index">
        <EvaluateStudent :student="student" :indicators="referent.indicators" :allNote="notes" />
    </template>
</template>

<script setup lang="ts">
import EvaluateStudent from './EvaluateStudent/EvaluateStudent.vue';
import { useEvaluateStore } from '@/store/EvaluteReferentStore';
import { storeToRefs } from 'pinia';

const referentStore = useEvaluateStore();

const { referent, studentsFilters, notes } = storeToRefs(referentStore);
</script>