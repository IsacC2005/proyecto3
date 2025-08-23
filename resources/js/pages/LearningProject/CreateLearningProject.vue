<template>
    <AppLayout>
        <h1>Crear un Nuevo Proyecto de Aprendizaje</h1>

        <div v-if="enrollment.length > 0">
            <h2 class="text-2xl font-bold">¡Ya estás inscrito en un proyecto!</h2>
        </div>

        <div v-else>
            <form @submit.prevent="submit" class="m-1 sm:m-8">
                <div class="mb-6">
                    {{ teacher_id }}
                    {{ enrollment_id }}
                    <label for="project_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Título del Proyecto
                    </label>
                    <input v-model="form.title" type="text" id="project_title"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg block w-full p-2.5"
                        placeholder="Ej: Curso de TypeScript" required />
                    <div v-if="form.errors.title" class="text-red-600 mt-2 text-sm">{{ form.errors.title }}</div>
                </div>

                <div v-for="(clase, index) in form.dailyClasses" :key="index" class="mb-4">
                    <label :for="'daily_class_' + index"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Clase del día {{ index + 1 }}
                    </label>
                    <input v-model="form.dailyClasses[index].title" type="text" :id="'daily_class_' + index"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg block w-full p-2.5"
                        placeholder="Ej: Introducción a Vue.js" required />
                    <div v-if="form.errors[`dailyClass.${index}`]" class="text-red-600 mt-2 text-sm">{{
                        form.errors[`dailyClass.${index}`] }}</div>

                    <InputDate v-model="form.dailyClasses[index].date" :id="'daily_class_date_' + index">
                    </InputDate>
                </div>

                <button type="button" @click="addClass"
                    class="mb-6 text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    Agregar otra clase
                </button>

                <button @click="test"> ho lla</button>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    :disabled="form.processing">
                    Crear Proyecto
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputDate from './components/InputDate.vue';

const props = defineProps({
    enrollment: {
        type: Array,
        required: true,
        default: () => [],
    },
    teacher_id: {
        type: Number,
        required: true,
    },
    enrollment_id: {
        type: Number,
        required: true,
    }

});

type LearningProject = {
    title: string;
    content: string;
    teacher_id: number;
    enrollment_id: number;
    dailyClasses: DailyClasses[];
};

type DailyClasses = {
    title: string,
    content: string,
    date: Date
}

const form = useForm<LearningProject>({
    title: '',
    content: '',
    teacher_id: props.teacher_id,
    enrollment_id: props.enrollment_id,
    dailyClasses: [{
        title: '',
        content: '',
        date: new Date()

    }],
});

const test = () => {
    console.log(form.dailyClasses[0])
}

const submit = () => {
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
        content: ''
    });
};
</script>
