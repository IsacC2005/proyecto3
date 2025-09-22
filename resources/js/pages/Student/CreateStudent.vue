<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { BreadcrumbItem } from '@/types';
import ContentPage from '@/components/ContentPage.vue';
import FormStudent from './Components/FormStudent/FormStudent.vue';
import { useStudentStore } from '@/store/StudentStore';
import { Representative } from '@/types/dtos';
import ButtonSubmit from '@/components/ui/button/ButtonSubmit.vue';
import SearchRepresentative from './Components/SearchRepresentative.vue';

const data = useStudentStore();

const { form, cleanForm } = data;

const props = defineProps<{ representative: Representative }>()

onMounted(() => {
    //form.representativeId = props.representative.id
})
const submit = () => {
    form.post(route('student.store'), {
        onSuccess() {
            cleanForm()
        }
    })
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lista de estudiantes',
        href: '/student/index'
    },
    {
        title: 'Crear estudiante',
        href: `/student/create/`,
    }
]
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Crear estudiante" />
        <Heading title="Crear estudiante" />
        <ContentPage>
            <SearchRepresentative :representative="props.representative" />
            <FormStudent v-if="props.representative" @submit.prevent="submit">
                <ButtonSubmit text="Crear estudiante" processing-text="Creando estudiante..."
                    :processing="form.processing" />
            </FormStudent>
        </ContentPage>
    </AppLayout>
</template>
