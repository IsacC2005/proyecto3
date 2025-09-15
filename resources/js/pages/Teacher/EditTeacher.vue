<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Heading :title="`Editar profesor`"
            :description="`Edita los datos de este profesor, y guardalos para preservar los cambios`"></Heading>
        <ContentPage>
            <FormTeacher @submit.prevent="submit">
                <div class="w-full pt-3">
                    <ButtonSubmit text="Guardar" processingText="Guardando..." :processing="form.processing" />
                </div>
            </FormTeacher>
        </ContentPage>
    </AppLayout>
</template>

<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Teacher } from '@/types/dtos';
import { defineProps, onMounted } from 'vue';
import { useTeacherStore } from '@/store/TeacherStore';
import ContentPage from '@/components/ContentPage.vue';
import FormTeacher from './components/FormTeacher/FormTeacher.vue';
import ButtonSubmit from '@/components/ui/button/ButtonSubmit.vue';

const data = useTeacherStore();

const { form, resetForm, somePassword, cleanPassword } = data;

const props = defineProps<{
    teacher: Teacher
}>();

onMounted(() => {
    form.name = props.teacher.name;
    form.surname = props.teacher.surname;
    form.phone = props.teacher.phone.toString();
    form.email = props.teacher.user.email;
    form.password = props.teacher.user.password;
})

const submit = () => {
    if (!somePassword()) {
        alert('que haces, escribe bien el password')
        //alert.showAlert(alertPasswordNotSome);
        cleanPassword();
        return;
    }

    form.put(route('teacher.update', {
        id: props.teacher.id,
        onSuccess() {
            resetForm();
        }
    }));
}




// const form = useForm({
//     name: props.teacher.name,
//     surname: props.teacher.surname,
//     phone: props.teacher.phone,
//     email: props.teacher?.user.email,
//     password: props.teacher.user.password
// });


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lista de profesores',
        href: '/teacher/index'
    },
    {
        title: 'Editar profesor',
        href: `/teacher/edit?teacherId=${props.teacher.id}`
    }
]
</script>
