<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submitShowRepresentative" class="m-1 sm:m-8">
            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Buscar Representante</label>

                <input v-model="formRepresentative.idcard" type="number" id="last_name"
                    class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                    placeholder="Doe" required />
                    <input type="submit" value="Buscar">
            </div>
        </form>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const formStudent = useForm({
    name: '',
    surname: '',
    phone: '',
    email: '',
    password: ''
});

const formRepresentative = useForm({
    idCard: '',
    name: '',
})

const representative = ref({});

const submit = () => {
    form.post(route('teacher.create'));
}

const submitShowRepresentative = () => {
    form.get(route('representative.show'));
}
</script>
