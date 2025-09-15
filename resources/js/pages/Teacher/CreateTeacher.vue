<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Heading title="Crear un nuevo profesor" description="Ingrese los datos del profesor para crear la cuenta" />

        <ContentPage>
            <FormTeacher @submit.prevent="submit">
                <div class="w-full pt-3">
                    <ButtonSubmit text="Crear Profesor" processingText="Creando Profesor..."
                        :processing="form.processing" />
                </div>
            </FormTeacher>
        </ContentPage>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { BreadcrumbItem } from '@/types';
import ContentPage from '@/components/ContentPage.vue';
import FormTeacher from './components/FormTeacher/FormTeacher.vue';
import { useTeacherStore } from '@/store/TeacherStore';
import { useAlertData } from '@/store/ModalStore';
import { Alert } from '@/types';
import ButtonSubmit from '@/components/ui/button/ButtonSubmit.vue';

const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Crear Profesor',
    href: '/teacher/create'
}]

const alertPasswordNotSome: Alert = {
    isOpen: true,
    title: '🚫¡Error!',
    description: 'La contraseña no coincide',
    message: 'La contraseña debe ser exactamente igual en las dos entradas',
    code: 0
}

const alert = useAlertData();

const data = useTeacherStore();

const { form, resetForm, somePassword, cleanPassword } = data;

const submit = () => {
    if (!somePassword()) {
        alert.showAlert(alertPasswordNotSome);
        cleanPassword();
        return;
    }

    form.post(route('teacher.create'), {
        onSuccess() {
            resetForm();
        }
    });
}

</script>
