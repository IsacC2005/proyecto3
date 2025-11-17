<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps, onMounted } from 'vue';
import Heading from '@/components/Heading.vue';
import { DailyClass } from '@/types/dtos';
import ContentPage from '@/components/ContentPage.vue';
import FormReferent from './components/FormReferent.vue';
import { useReferenStore } from '@/store/ReferentStore';
import { useAlertData } from '@/store/ModalStore';
import { alertInidicatorsPart, alertReferentUpdate } from './Alerts';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const alertData = useAlertData();

const { showAlert } = alertData;


const data = useReferenStore();

const { form } = data;

const props = defineProps<{
    dailyClass: DailyClass
}>()

onMounted(() => {
    form.title = props.dailyClass.title;
    form.content = props.dailyClass.content;
    form.indicators = props.dailyClass.indicators;
    form.date = props.dailyClass.date;
})

const submit = () => {
    if (form.indicators.length % 2 === 1 || form.indicators.length === 0) {
        form.put(`/daily-class/update/${props.dailyClass.id}`, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                form.reset();
                showAlert(alertReferentUpdate);
            }
        });
    } else {
        showAlert(alertInidicatorsPart)
    }
};

const cancel = () => {
    form.reset();
    window.history.back();
}

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Lista de proyectos',
        href: '/learning-project/index',
    },
    {
        title: props.dailyClass.learningProject?.title ?? 'Proyecto',
        href: '/learning-project/show/' + props.dailyClass.learningProject?.id,
    },
    {
        title: 'Resumen de calificaciones',
        href: '/learning-project/notes/',
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Modificar Referente Teórico" />
        <Heading title="Modificar Referente Teórico"
            description="Los referentes teóricos una ves evaluados no pueden ser modificados">
        </Heading>

        <ContentPage>
            <FormReferent @submit.prevent="submit">
                <div class="flex flex-col sm:flex-row items-center justify-between mt-8 gap-4">
                    <button type="submit" :disabled="form.processing"
                        class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span v-if="form.processing">Guardando...</span>
                        <span v-else>
                            Actualizar Referente Teórico</span>
                    </button>

                    <button type="button" @click="cancel"
                        class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                        Cancelar
                    </button>
                </div>
            </FormReferent>
        </ContentPage>
    </AppLayout>
</template>
