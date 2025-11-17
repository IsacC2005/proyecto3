<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { LearningProject } from '@/types/dtos';
import Input from '@/components/ui/input/Input.vue'
import Label from '@/components/ui/label/Label.vue';
import Editor from '@/components/ui/editor/Editor.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import ButtonSubmit from '@/components/ui/button/ButtonSubmit.vue';
import { useAlertData } from '@/store/ModalStore';
import { ContentVeryLong } from './Alerts';
import { BreadcrumbItem } from '@/types';

const alertData = useAlertData();

const props = defineProps<{
    project: LearningProject
}>()


const model = ref(props.project.content);

const form = useForm({
    id: props.project.id,
    title: props.project.title,
    content: props.project.content,
    schoolMoment: props.project.schoolMoment
});

const submit = () => {
    if (model.value.length > 20) {
        alertData.showAlert(ContentVeryLong)
        return;
    }
    form.content = model.value;

    console.log(form)
    // Usa el método PUT para actualizar el recurso existente
    // La ruta debe incluir el ID del proyecto
    form.put(route('learning-project.update'), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Proyecto actualizado con éxito');
        },
        onError: (errors) => {
            console.error('Error al actualizar el proyecto:', errors);
        }
    });
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Lista de proyectos',
        href: '/learning-project/index',
    },
    {
        title: 'Proyecto',
        href: '/learning-project/show/' + props.project.id,
    },
    {
        title: 'Editar Proyecto',
        href: '/learning-project/edit/' + props.project.id,
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Editar Proyecto" />
        <Heading title="Modificar el proyecto de aprendizaje" />
        <!-- {{ props.project }} -->
        <form @submit.prevent="submit" class="m-1 sm:m-8">
            <Label for="title">Titulo del proyecto</Label>
            <Input v-model="form.title" class="mt-4 mb-8" maxlength="254" id="title" type="text"
                placeholder="Nuestros Vecinos del Huerto: Un Viaje al Mundo de los Insectos" />

            <Label>Diagnóstico y Propósito</Label>
            <Editor class=" mt-4" v-model="model" />

            <div class="mt-4 mr-1.5 flex flex-row justify-end">
                <ButtonSubmit class="w-full sm:w-fit" type="submit" text="Actializar Proyecto"
                    processing-text="Actializando Proyecto" :processing="form.processing" />
            </div>
        </form>
    </AppLayout>
</template>
