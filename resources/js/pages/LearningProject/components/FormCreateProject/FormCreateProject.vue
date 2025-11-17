<template>
    <form @submit.prevent="submit" class="m-1 sm:m-8 sm:mt-2">
        <h3 class="text-xl sm:text-2xl font-semibold text-foreground mb-6 mt-0 text-center sm:text-left">
            {{ moments[props.schoolMoment] }}
        </h3>
        <Label for="title" class="text-gray-800">Titulo del proyecto <span
                class="text-red-400 font-bold size-4">*</span></Label>
        <Input v-model="form.title" class="mt-4 mb-8" maxlength="254" id="title" type="text"
            placeholder="Nuestros Vecinos del Huerto: Un Viaje al Mundo de los Insectos" required />

        <Label>
            Diagnóstico y Propósito </Label>
        <Editor class=" mt-4" v-model="model" />

        <button type="submit" class="w-full sm:w-auto mt-4 px-5 py-2.5 text-center 
           font-semibold rounded-xl text-lg transition duration-200 
           shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 
           
           /* Colores Normales: Verde Esmeralda */
           text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-300
           
           /* Estilo al estar Deshabilitado */
           disabled:opacity-60 disabled:cursor-not-allowed disabled:shadow-none" :disabled="form.processing">

            <span v-if="form.processing">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Procesando...
            </span>

            <span v-else>
                Crear Proyecto
            </span>
        </button>

    </form>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
</template>

<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Editor from '@/components/ui/editor/Editor.vue';
import FormCreateClasses from './FormCreateClasses.vue';

const model = ref("");

const props = defineProps<{
    teacherId: number
    schoolMoment: 1 | 2 | 3
    enrollmentId: number
}>()

const form = useForm<LearningProject>({
    title: '',
    content: '',
    teacherId: props.teacherId,
    enrollmentId: props.enrollmentId,
    schoolMoment: props.schoolMoment,
    dailyClasses: [{
        title: '',
        content: '',
        date: new Date()
    }],
});

const submit = () => {
    form.content = model.value;
    form.post('/learning-project/store', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        }
    });
};

const addClass = () => {
    form.dailyClasses.push({
        title: '',
        content: '',
        date: new Date()
    });
}

const moments = {
    1: "Momento I",
    2: "Momento II",
    3: "Momento III"
};


type LearningProject = {
    title: string;
    content: string;
    teacherId: number;
    enrollmentId: number;
    schoolMoment: 1 | 2 | 3;
    dailyClasses: DailyClasses[];
};

type DailyClasses = {
    title: string,
    content: string,
    date: Date
}
</script>