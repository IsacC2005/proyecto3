<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Heading :title="`Editar profesor`"
            :description="`Edita los datos de este profesor, y guardalos para preservar los cambios`"></Heading>
        <form @submit.prevent="submit" class="m-1 sm:m-8">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nombre</label>

                    <input v-model="form.name" type="text" id="last_name"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="Doe" required />
                </div>
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Apellido</label>
                    <input v-model="form.surname" type="text" id="last_name"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="Doe" required />
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Numero de Telefono
                    </label>
                    <input v-model="form.phone" type="tel" id="phone"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="123-45-678" pattern="[0-9]{9}" required />
                </div>
            </div>
            <label for="seccion_access" Class="mb-2 inline-block">
                Datos de acceso
            </label>
            <section id="secction_access" class="border border-accent-foreground rounded-lg p-3.5">
                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Correo Electronico
                    </label>
                    <input v-model="form.email" type="email" id="email"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="john.doe@company.com" required />
                </div>
                <div class="mb-6">
                    <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input v-model="form.password" type="password" id="password"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="•••••••••" required />
                </div>
                <div class="mb-6">
                    <label for="confirm_password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                        password</label>
                    <input type="password" id="confirm_password"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="•••••••••" required />
                </div>
            </section>
            <input type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" />
        </form>
    </AppLayout>
</template>

<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Teacher } from '@/types/dtos';
import { useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';


const props = defineProps<{
    teacher: Teacher
}>()

const form = useForm({
    name: props.teacher.name,
    surname: props.teacher.surname,
    phone: props.teacher.phone,
    email: props.teacher.user.email,
    password: props.teacher.user.password
});

const submit = () => {
    form.get(route('teacher.update', { id: props.teacher.id }));
}

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
