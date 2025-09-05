<template>
    <label :for="'daily_class_' + index" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Clase del día {{ index + 1 }}
    </label>
    <input v-model="dailyClass.title" type="text" :id="'daily_class_' + index"
        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg block w-full p-2.5"
        placeholder="Ej: Introducción a Vue.js" required />

    <InputDate v-model="dailyClass.date" :id="'daily_class_date_' + index">
    </InputDate>
</template>

<script setup lang="ts">
import { DefineProps, watch } from 'vue';
import InputDate from './InputDate.vue';
import { ref } from 'vue';

const myDate = ref({});





const props = defineProps({
    index: {
        type: Number,
        required: true,
    },
    modelValue: {
        type: Object as () => DailyClasses,
        required: true,
        default: () => ({
            title: '',
            content: '',
            date: new Date()
        })
    },
})

const dailyClass = ref(props.modelValue);

watch(dailyClass, (newValue) => {
    console.log('Fecha seleccionada:', newValue);
}, { deep: true });

const sendDate = (date) => {
    myDate.value = date;
}

type DailyClasses = {
    title: string,
    content: string,
    date: Date
}
</script>
