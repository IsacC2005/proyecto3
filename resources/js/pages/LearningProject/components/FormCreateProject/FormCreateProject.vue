<template>
    <form @submit.prevent="submit" class="m-1 sm:m-8 sm:mt-2">
        <h3 class="text-xl sm:text-2xl font-semibold text-foreground mb-6 mt-0 text-center sm:text-left">
            {{ moments[props.schoolMoment] }}
        </h3>
        <Label for="title">Titulo del proyecto</Label>
        <Input v-model="form.title" class="mt-4 mb-8" id="title" type="text"
            placeholder="Nuestros Vecinos del Huerto: Un Viaje al Mundo de los Insectos" />

        <Label>
            Diagnóstico y Propósito </Label>
        <Editor class=" mt-4" v-model="model" />

        <div class="flex flex-col my-4">
            <FormCreateClasses :dailyClasses="form.dailyClasses"></FormCreateClasses>
            <button @click="addClass"
                class="mt-4 font-medium text-sm w-full sm:w-fit px-5 py-2.5 text-center text-foreground bg-blue-500 hover:bg-blue-600 rounded-lg">Agregar
                Referente Teorico</button>
        </div>

        <button type="submit"
            class="text-foreground bg-emerald-700 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            :disabled="form.processing">
            Crear Proyecto
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
    form.post(route('learning-project.create'), {
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