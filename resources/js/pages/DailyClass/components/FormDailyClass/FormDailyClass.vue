<template>
    <form @submit.prevent="submit" class="bg-white rounded-lg shadow-md px-6 sm:px-6">
        <div class="mb-6">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                Título de la Clase:
            </label>
            <input id="title" type="text" v-model="form.title"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                required>
            <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">
                {{ form.errors.title }}
            </div>
        </div>

        <div class="mb-6">
            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">
                Contenido:
            </label>
            <Editor v-model="form.content"></Editor>
            <div v-if="form.errors.content" class="text-red-500 text-xs mt-1">
                {{ form.errors.content }}
            </div>
        </div>

        ---
        <FormDailyClassIndicators @inidicators-update="changeIndicators" :indicators="props.dailyClass.indicators">
        </FormDailyClassIndicators>

        <slot name="submit" :processing="form.processing">
            <button :disabled="form.processing"
                class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <span v-if="form.processing">Procesando...</span>
                <span v-else>Enviar</span>
            </button>
        </slot>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { DailyClass, Indicator } from '@/types/dtos';
import FormDailyClassIndicators from './FormDailyClassIndicators.vue';
import { ref } from 'vue';
import Editor from '@/components/ui/editor/Editor.vue';

const props = defineProps<{
    dailyClass: DailyClass
}>()


const listIndicators = ref(props.dailyClass.indicators);

const changeIndicators = (value: Indicator[]) => {
    listIndicators.value = value;
}

const form = useForm({
    title: props.dailyClass.title,
    content: props.dailyClass.content,
    indicators: listIndicators.value,
});

const submit = () => {
    form.indicators = listIndicators.value
    form.put(`/daily-class/update/${props.dailyClass.id}`, {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>