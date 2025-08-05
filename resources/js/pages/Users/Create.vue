<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';

const props = defineProps({
    roles: Array,
});

let hola = "Hollla";
const form = useForm ({
    name: '',
    email: '',
    password: '',
    rol_id: ''
});

const submit = () => {
    form.post(route('user.create'),{})
}

</script>

<template>
    <AppLayout>
        <form @submit.prevent="submit">
            <h2 :value="hola">{{ valor }}</h2>
            <label for="">
                Nombre:
                <input v-model="form.name" name="name" type="text">
            </label>

            <label for="">
                Email:
                <input v-model="form.email" name="email" type="email">
            </label>

            <label for="">
                Password:
                <input v-model="form.password" name="password" type="password">
            </label>
            <select v-model="form.rol_id" name="select" id="">
                <option :value="null">Selecciona un rol</option>
                <option v-for="rol in props.roles" :key="rol.id" :value="rol.id">{{ rol.name }}</option>
            </select>
            <button type="submit">Enviar</button>
        </form>
    </AppLayout>

</template>

<style></style>