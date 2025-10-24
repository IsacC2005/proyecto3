<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps, onMounted } from 'vue';
import Heading from '@/components/Heading.vue';
import ContentPage from '@/components/ContentPage.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import ButtonSubmit from '@/components/ui/button/ButtonSubmit.vue';
import { useCreateUserForTeacher } from '@/store/TeacherStore';
import { storeToRefs } from 'pinia';
import { Teacher } from '@/types/dtos';

const data = useCreateUserForTeacher();

const { repeatPassword } = storeToRefs(data);
const { form } = useCreateUserForTeacher();

const props = defineProps<{
    teacher: Teacher
}>()

onMounted(() => {
    form.id = props.teacher.id
    form.name = `${props.teacher.name} ${props.teacher.surname}`
})

const submit = () => {
    form.post(route('teacher.create-user'), {
        onSuccess() {
            form.reset();
        }
    })
}

</script>

<template>
    <AppLayout>
        <Heading title="Crear nuevo usuario" />
        <form @submit.prevent="submit">
            <ContentPage>
                <section class="relative border border-emerald-200 rounded-lg p-3.5 pt-7">
                    <h3 class="absolute -top-3.5 left-3 bg-background px-3 border border-emerald-200 rounded">Datos de
                        acceso</h3>
                    <div class="mb-6">
                        <Label for="email" class="block mb-2 text-sm font-medium text-foreground">
                            Correo Electronico
                        </Label>
                        <Input type="email" id="email" v-model="form.email" placeholder="john.doe@company.com"
                            required />
                    </div>
                    <div class="mb-6">
                        <Label for="password" class="block mb-2 text-sm font-medium text-foreground">Contraseña</Label>
                        <Input type="password" id="password" v-model="form.password" placeholder="•••••••••" required />
                    </div>
                    <div class="mb-6">
                        <Label for="confirm_password" class="block mb-2 text-sm font-medium text-foreground">Confirmar
                            Contraseña</Label>
                        <Input type="password" id="confirm_password" v-model="repeatPassword" placeholder="•••••••••"
                            required />
                    </div>
                </section>
                <ButtonSubmit text="Crear Usuario" processingText="Creando Usuairo..." class="mt-2 sm:mt-4" />
            </ContentPage>
            <button type="submit">Enviar</button>
        </form>
    </AppLayout>

</template>