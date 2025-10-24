<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import Heading from '@/components/Heading.vue';
import ContentPage from '@/components/ContentPage.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import InputAccessData from './Components/InputAccessData.vue';
import ButtonSubmit from '@/components/ui/button/ButtonSubmit.vue';
import { useUserStore } from '@/store/UserStore';

const { form } = useUserStore();

type Role = {
    id: number;
    name: string;
}

// const props = defineProps<{
//     roles: Role[]
// }>()


const submit = () => {
    form.post(route('user.create'), {
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
                <div class="mb-6">
                    <Label for="username" class="block mb-2 text-sm font-medium text-foreground">
                        Nombre de usuario
                    </Label>
                    <Input type="text" id="username" v-model="form.name" required />
                </div>
                <InputAccessData />
                <ButtonSubmit text="Crear Usuario" processingText="Creando Usuairo..." class="mt-2 sm:mt-4" />
            </ContentPage>
            <button type="submit">Enviar</button>
        </form>
    </AppLayout>

</template>