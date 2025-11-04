<template>
    <AppLayout>
        <Heading title="Detalles del proyecto"></Heading>
        <div class="p-4 sm:p-6 md:p-8">
            <h2 class="text-xl sm:text-2xl font-semibold text-indigo-600 mb-6">{{ props.project.title }}</h2>

            <div class="flex flex-col flex-wrap sm:flex-row items-center gap-4 mb-8">
                <button @click="ModalOpen = true"
                    class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                    Crear Referentes Teóricos
                </button>
                <Link :href="`/learning-project/edit/${props.project.id}`"
                    class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                Modificar Proyecto
                </Link>
                <Link href="/qualitie" :data="{ learning_project_id: props.project.id }"
                    class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                Evaluar Cualidades de los estudiantes</Link>
                <Link href="/learning-project/notes/" :data="{ projectId: props.project.id }"
                    class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                Ver Resumen de notas</Link>
                <Link :href="`/tickets/${props.project.id}`"
                    class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                Ver Boletas</Link>
                <Link :href="`/tickets/create/${props.project.id}`"
                    class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                Crear Boletas</Link>
            </div>

            <div class="space-y-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-3">Descripción General</h3>
                    <div v-html="props.project.content" class="text-gray-600 leading-relaxed prose max-w-none"></div>
                </div>

                <div v-for="dailyClass in props.project.dailyClasses" :key="dailyClass.id"
                    class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-1">{{ dailyClass.title }}</h3>
                            <p class="text-sm text-gray-500">Fecha: {{ formatDate(dailyClass.date) }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <Link :href="`/teacher/evaluate/class`" :data="{ classId: dailyClass.id }"
                                class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 transition-colors duration-200">
                            Evaluar
                            </Link>
                            <Link :href="`/daily-class/edit/${dailyClass.id}`"
                                class="px-4 py-2 bg-indigo-500 text-white font-semibold rounded-md hover:bg-green-600 transition-colors duration-200">
                            Modificar
                            </Link>
                        </div>
                    </div>

                    <div v-html="dailyClass.content" class="text-gray-600 mb-4 prose max-w-none"></div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps, onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { LearningProject } from '@/types/dtos';
import Heading from '@/components/Heading.vue';

const props = defineProps<{
    project: LearningProject,
    newClass: {
        type: boolean,
        default: false
    }
}>()

const ModalOpen = ref(false);

onMounted(() => {
    if (props.newClass) {
        ModalOpen.value = true;
    }
});

// Formatea la fecha, reutilizando la misma función del componente anterior
const formatDate = (dateObject: any) => {
    if (!dateObject || !dateObject.date) return '';
    const date = new Date(dateObject.date);
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>
