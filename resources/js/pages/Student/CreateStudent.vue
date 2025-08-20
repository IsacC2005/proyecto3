<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <!--Mostrar los datos del representante-->

        <div v-if="representative" class="m-1 sm:m-8">
            <h2>Datos del representante</h2>
            <div>
                <label for="r_idcard" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Cedula de identidad</label>

                <input type="text" id="r_idcard"
                    class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                    :value="representative.idcard" />
            </div>

            <div>
                <label for="r_phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Numero de telefono</label>

                <input type="text" id="r_phone"
                    class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                    :value="representative.phone" />
            </div>

            <div>
                <label for="r_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Nombre</label>

                <input type="text" id="r_name"
                    class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                    :value='representative.name + " " + representative.surname' />
            </div>
        </div>


        <!-- Formulario de busqueda del representante -->
        <div v-else>
            <form @submit.prevent="submitFindRepresentative(formRepresentative.idCard)" class="m-1 sm:m-8">
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Buscar Representante</label>

                    <input v-model="formRepresentative.idCard" type="number" id="last_name"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="31.625.450" required enablet />
                    <input type="submit">
                </div>
            </form>
        </div>


        <!-- Formulario del estudiante -->
        <div v-if="representative">
            <form @submit.prevent="submitCreateStudent" class="m-1 sm:m-8">
                <h2>Datos del estudiante</h2>
                <div>
                    <label for="e_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nombre</label>

                    <input type="text" id="e_name" v-model="formStudent.name"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="Ej. Jose Ramon" required />
                </div>
                <div>
                    <label for="e_surname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Apellido</label>

                    <input type="text" id="e_surname" v-model="formStudent.surname"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="Ej. Camejo" required />
                </div>

                <div>
                    <label for="e_degree" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Grado academico</label>

                    <input type="number" min="0" max="5" id="e_degree" v-model="formStudent.degree"
                        class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg focus:border- block w-full p-2.5"
                        placeholder="0" required />
                </div>
                <input type="submit">
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    representative: {
        type: Array,
        required: false
    }
});

const formStudent = useForm({
    name: '',
    surname: '',
    degree: '',
    representative_id: props.representative && props.representative.id ? props.representative.id : 0
});

const formRepresentative = useForm({
    idCard: '',
    name: '',
})

const submitCreateStudent = () => {
    formStudent.post(route('student.create'));
}

const submitFindRepresentative = (num) => {
    router.get('/student/create/', {
        idcard: num
    }, {
        preserveState: true,
        only: ['representative']
    });
}
</script>
