<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import FormReferent from './components/FormReferent.vue';
import ContentPage from '@/components/ContentPage.vue';
import { useReferenStore } from '@/store/ReferentStore';
import { useAlertData } from '@/store/ModalStore';
import { alertInidicatorsPart } from './Alerts';
import { onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { trainingArea } from '@/types/dtos';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
    projectId: number,
    trainingArea: trainingArea[]
}>()

const alertData = useAlertData();

const { showAlert } = alertData;

const data = useReferenStore();

const { ListTrainingArea } = storeToRefs(data);

const { resetForm, form } = data;

onMounted(() => {
    resetForm();
    ListTrainingArea.value = props.trainingArea;
})

const store = () => {
    if (form.indicators.length === 0 || form.indicators.length % 2 === 1) {
        form.projectId = props.projectId;
        form.post(route('daily-class.create'));
        resetForm();
    } else {
        showAlert(alertInidicatorsPart);
    }
}
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Lista de proyectos',
        href: '/learning-project/index',
    },
    {
        title: 'Proyecto',
        href: '/learning-project/show/' + props.projectId,
    },
    {
        title: 'Resumen de calificaciones',
        href: '/learning-project/notes/',
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Crear Referente Teórico" />
        <Heading title="Crear Referente Teórico" />
        <ContentPage>
            <FormReferent @submit.prevent="store">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Crear Referente Teorico
                </button>
            </FormReferent>
        </ContentPage>
    </AppLayout>

</template>
