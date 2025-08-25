<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        {{ enrollment }}
        <h1>
            {{ `Estos son los estudiantes que puedes inscribir en ${grade[0][enrollment.degree]} seccion
            '${enrollment.section.toUpperCase()}' ${enrollment.school_year}` }}
        </h1>
        select
        <DataTablet :items="students.data" :headers="headers">
            <template #body="{ item }">
                <td class="py-4 px-6 text-primary">{{ grade[0][item.degree] }}</td>
                <td class="py-4 px-6 text-primary">{{ item.name }}</td>
                <td class="py-4 px-6 text-primary">{{ item.surname }}</td>
                <td :key="item.id" class="py-4 px-6 text-primary">
                    <Link href="/enrollment/add-student" method="post"
                        :data="{ enrollment_id: enrollment.id, student_id: item.id }" class="
                            text-foreground
                            border border-muted-foreground
                            hover:text-background hover:bg-foreground
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 00">Modificar</Link>
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
        required: true
    },
    enrollment: {
        type: Array,
        required: true
    }
});

const headers = [
    'Grado',
    'Nombre',
    'Apellido',
    'Acciones'
];

const grade = [
    {
        0: 'Preescolar',
        1: 'Primer Grado',
        2: 'Segundo Grado',
        3: 'Tercer Grado',
        4: 'Cuarto Grado',
        5: 'Quinto Grado',
        6: 'Sexto Grado'
    }
];

</script>
