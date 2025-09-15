<script setup lang="ts">
import InputDate from '@/pages/LearningProject/components/InputDate.vue';
import { useReferenStore } from '@/store/ReferentStore';

const data = useReferenStore();
</script>


<template>
    <InputDate id="0" v-model="data.form.date" />
</template>