<template>
    <AppLayout>
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

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import FormReferent from './components/FormReferent.vue';
import ContentPage from '@/components/ContentPage.vue';
import { useReferenStore } from '@/store/ReferentStore';
import { useAlertData } from '@/store/ModalStore';
import { alertInidicatorsPart } from './Alerts';
import { onMounted } from 'vue';

const props = defineProps({
    projectId: {
        type: Number,
        required: true
    }
})

const alertData = useAlertData();

const { showAlert } = alertData;

const data = useReferenStore();

const { resetForm, form } = data;

onMounted(() => {
    resetForm();
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
</script>