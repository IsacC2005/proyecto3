<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <DataTablet :items="students.data" :headers="headers">
            <template #body="{ item }">
                <td class="py-4 px-6 text-primary">{{ item.degree }} Grado</td>
                <td class="py-4 px-6 text-primary">{{ item.name }}</td>
                <td class="py-4 px-6 text-primary">{{ item.surname }}</td>
                <td :key="item.id" class="py-4 px-6 text-primary">
                    <a :href="`/teacher/edit/${item.id}`" class="
                            text-foreground
                            border border-muted-foreground
                            hover:text-background hover:bg-foreground
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 00">Modificar</a>
                </td>
            </template>
        </DataTablet>
        <Paginator :pages="students.links" />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import DataTablet from '@/components/DataTablet.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import Paginator from '@/components/Paginator.vue';


import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})


const props = defineProps({
    students: {
        type: Array,
        requerid: true
    },
});

const headers = [
    'Grado',
    'Nombre',
    'Apellido',
    'Acciones'
];

</script>
