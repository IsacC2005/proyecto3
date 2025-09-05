<template>
    <AppLayout>
        <template v-if="!exist">
            <Heading title="Crear un nuevo Proyecto de Aprendizaje"
                description="No es necesario que carges todas las clases diarias de tu proyecto de aprendizaje, puedes cargar tan solo el titulo 
                y el contenido y despues ir agregando las demas clases cuando las necesites y agregarles los indicadores correspondientes" />

            <FormCreateProject :enrollmentId="props.enrollmentId" :teacherId="props.teacherId" />
        </template>
        <template v-else>
            <Heading title="¡Ya existe un proyecto de aprendizaje para esta secion!"
                description="Esta seccion ya tiene un proyecto de aprendizaje creado, si necesitas modificarlo o agregar mas clases puedes hacerlo desde la pagina de modificacion de proyecto" />
        </template>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import Heading from '@/components/Heading.vue';
import FormCreateProject from './components/FormCreateProject/FormCreateProject.vue';

const props = defineProps({
    exist: {
        type: Boolean,
        required: true
    },
    teacherId: {
        type: Number,
        required: true,
    },
    enrollmentId: {
        type: Number,
        required: true,
    }
});
</script>
