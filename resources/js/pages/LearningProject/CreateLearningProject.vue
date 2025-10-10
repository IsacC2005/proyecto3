<template>
    <AppLayout>
        <template v-if="select">
            <Heading title="Crear un nuevo Proyecto de Aprendizaje"
                description="No es necesario que carges todas las clases diarias de tu proyecto de aprendizaje, puedes cargar tan solo el titulo 
                y el contenido y despues ir agregando las demas clases cuando las necesites y agregarles los indicadores correspondientes" />

            <FormCreateProject :enrollmentId="props.enrollmentId" :schoolMoment="select" :teacherId="props.teacherId" />
        </template>
        <template v-else>
            <Heading title="Selecciona el Tipo de Proyecto de Aprendizaje a Crear"
                description="Una sección puede tener hasta tres momentos de proyectos de aprendizaje. Selecciona la opción que deseas crear en este momento." />
            <ProjectCreationOptions :projects="props.projects" @selectType="select = $event" />
        </template>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps, ref } from 'vue';
import Heading from '@/components/Heading.vue';
import FormCreateProject from './components/FormCreateProject/FormCreateProject.vue';
import ProjectCreationOptions from './components/ProjectCreationOptions/ProjectCreationOptions.vue';
import { LearningProject } from '@/types/dtos';


const props = defineProps<{
    projects: LearningProject[]
    teacherId: number
    enrollmentId: number
}>()

const select = ref();
</script>
