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
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    roles: {
        type: Object
    }
})

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

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Gestión de Usuarios',
        href: '/user/index',
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Crear usuario" />
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
                <Label for="select-role" class="block my-2 text-sm font-medium text-foreground">Selecciona un
                    rol</Label>
                <select id="select-role" required v-model="form.roleId"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border bg-white">
                    <option value="" disabled>-- Selecciona un rol --</option>
                    <option v-for="modelName in props.roles" :key="modelName.id" :value="modelName.id">
                        {{ modelName.name }}
                    </option>
                </select>
                <ButtonSubmit text="Crear Usuario" processingText="Creando Usuairo..." class="mt-2 sm:mt-4" />
            </ContentPage>
        </form>
    </AppLayout>

</template>