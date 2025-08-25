<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <h2 class="text-center text-3xl pt-4">
            Ingresa los datos del profesor</h2>
        <form @submit.prevent="submit" class="m-1 sm:m-8">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-foreground">
                        Nombre</label>

                    <input v-model="form.name" type="text" id="last_name"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg block w-full p-2.5"
                        placeholder="Doe" required />
                </div>
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-foreground">
                        Apellido</label>
                    <input v-model="form.surname" type="text" id="last_name"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg block w-full p-2.5"
                        placeholder="Doe" required />
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-foreground">
                        Numero de Telefono
                    </label>
                    <input v-model="form.phone" type="tel" id="phone"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg block w-full p-2.5"
                        placeholder="0416-652-67-49" pattern="[0-9]{11}" required />
                </div>
            </div>
            <label for="seccion_access" Class="mb-2 inline-block">
                Datos de acceso
            </label>
            <section id="secction_access" class="border border-accent-foreground rounded-lg p-3.5">
                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-foreground">
                        Correo Electronico
                    </label>
                    <input v-model="form.email" type="email" id="email"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="john.doe@company.com" required />
                </div>
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-foreground">Password</label>
                    <input v-model="form.password" type="password" id="password"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="•••••••••" required />
                </div>
                <div class="mb-6">
                    <label for="confirm_password" class="block mb-2 text-sm font-medium text-foreground">Confirm
                        password</label>
                    <input type="password" v-model="confirmPassword" id="confirm_password"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="•••••••••" required />
                </div>
            </section>
            <input type="submit"
                class="text-foreground bg-chart-2 hover:bg-chart-1 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mt-4 text-center" />
        </form>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    surname: '',
    phone: '',
    email: '',
    password: ''
});

const confirmPassword = ref('');

const submit = () => {
    if (form.password !== confirmPassword.value) {
        alert('Las contraseñas no coinciden');
        confirmPassword.value = '';
        return;
    }
    form.post(route('teacher.create'));
}

</script>
