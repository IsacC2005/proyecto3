<template>
    <Label :for="'daily_class_' + index" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Referente Teorico #{{ index + 1 }}
    </Label>
    <Input v-model="dailyClass.title" type="text" :id="'daily_class_' + index" placeholder="Ej: Introducción a Vue.js"
        required />

    <InputDate v-model="dailyClass.date" :id="'daily_class_date_' + index" />
</template>

<script setup lang="ts">
import InputDate from '../InputDate.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { ref } from 'vue';

const props = defineProps<{
    index: number,
    dailyClass: DailyClass
}>()

type DailyClass = {
    title: string,
    content: string,
    date: Date
}

const dailyClass = ref(props.dailyClass);
</script>
