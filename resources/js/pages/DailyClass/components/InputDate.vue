<script setup lang="ts">
import InputDate from '@/pages/LearningProject/components/InputDate.vue';
import { useReferenStore } from '@/store/ReferentStore';
import { computed, ref, watch } from 'vue';

const data = useReferenStore();

const dateSelect = ref();
watch(dateSelect, () => {
    console.log(dateSelect)
    //data.form.date = dateSelect
})

</script>


<template>
    <InputDate id="0" :model-value="data.form.date" @update:model-value="dateSelect" />
</template>