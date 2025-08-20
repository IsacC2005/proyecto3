<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 bg-background rounded-lg shadow-md relative">
            <h1 class="text-2xl font-bold mb-4 text-primary dark:text-primary">Lista de Profesores</h1>

            <!---->

            <div class="pb-4 bg-transparent">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search"
                        class="block pt-2 ps-10 text-sm text-card-foreground border border-bo rounded-lg w-80 bg-card focus:ring-accent focus:border-accent placeholder:text-muted"
                        placeholder="Search for items">
                </div>
            </div>

            <!---->

            <DataTable :items="teachers.data" :headers="headers">
                <template #body="{ item }">
                    <td class="py-4 px-6 text-primary">{{ item.name }}</td>
                    <td class="py-4 px-6 text-primary">{{ item.surname }}</td>
                    <td class="py-4 px-6 text-primary">{{ item.phone }}</td>
                    <td :key="item.id" class="py-4 px-6 text-primary">
                        <button @click="assign(item.id, id_enrollment)" class="
                            text-foreground
                            border border-muted-foreground
                            hover:text-background hover:bg-foreground
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 00">Modificar</button>
                    </td>
                </template>
            </DataTable>

            <Paginator v-if="teachers.links && teachers.links.length > 3" :pages="teachers.links" />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import DataTable from '@/components/DataTablet.vue'
import BotomGrup from '@/components/BotomGrup.vue';
import Paginator from '@/components/Paginator.vue';
import { router, useForm } from '@inertiajs/vue3';


const props = defineProps({
    id_enrollment: {
        type: Number,
        required: true,
    },
    teachers: {
        type: Array,
        required: true,
    },
});

const assign = (id_enrollment: number, id_teacher: number) => {
    router.post('/enrollment/assign-teacher', {
        id_enrollment: id_enrollment,
        id_teacher: id_teacher
    });
}

// Definimos las columnas de la tabla de forma declarativa
const headers = [
    'Nombre',
    'Apellido',
    'Teléfono',
    'Acciones'
];
</script>
