<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 bg-background rounded-lg shadow-md relative">
            <h1 class="text-2xl font-bold mb-4 text-primary dark:text-primary">Lista de Profesores</h1>


            <DataTable :items="teachers.data" :headers="headers">
                <template #body="{ item }">
                    <td class="py-4 px-6 text-primary">{{ item.name }}</td>
                    <td class="py-4 px-6 text-primary">{{ item.surname }}</td>
                    <td class="py-4 px-6 text-primary">{{ item.phone }}</td>
                    <td :key="item.id" class="py-4 px-6 text-primary">
                        <a :href="`/teacher/edit/${item.id}`" class="
                            text-foreground
                            border border-muted-foreground
                            hover:text-background hover:bg-foreground
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 00">Modificar</a>
                    </td>
                </template>
            </DataTable>
            <Paginator :pages="teachers.links"/>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import DataTable from '@/components/DataTablet.vue'
import BotomGrup from '@/components/BotomGrup.vue';
import Paginator from '@/components/Paginator.vue';


const props = defineProps({
    teachers: {
        type: Array,
        required: true,
    },
});

// Definimos las columnas de la tabla de forma declarativa
const headers = [
    'Nombre',
    'Apellido',
    'Teléfono',
    'Acciones'
];
</script>
