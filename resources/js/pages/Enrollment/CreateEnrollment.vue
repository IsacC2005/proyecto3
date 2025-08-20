<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" class="m-1 sm:m-8">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <!---->
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Grado de la seccion</label>
                    <select v-model="form.grade" id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Seleccione un grado</option>
                        <option value="1">Primer grado</option>
                        <option value="2">Segundo grado</option>
                        <option value="3">Tercer grado</option>
                        <option value="4">Cuarto grado</option>
                        <option value="5">Quinto grado</option>
                        <option value="6">Sexto grado</option>
                    </select>
                    <!---->
                </div>
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Secccion</label>
                    <input v-model="form.secction" type="text" id="last_name"
                        class="bg-input border border-muted-foreground text-foreground text-sm uppercase rounded-lg focus:border- block w-full p-2.5"
                        placeholder="A" required />
                </div>
                <input type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" />
            </div>
        </form>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    grade: '',
    secction: '',
});

const submit = () => {
    form.post(route('enrollment.create'));
}

</script>
