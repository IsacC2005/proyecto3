<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { LearningProject, Student } from '@/types/dtos';
import StudentTicketTable from './Components/StudentTicketTable.vue'; // Importamos la nueva tabla
import axios from 'axios';

// Definición de Props basada en los datos que recibes
const props = defineProps<{
    project: LearningProject,
    students: Student[]
}>();

// Función de ejemplo para Crear Todos
const createAllBoletines = async () => {
    try {
        const response = await axios.post(`/tickets/storeLot/${props.project.id}`);
        console.log('Boletines creados con éxito:', response.data);
        alert('✅ ¡Todos los boletines han sido creados!');
    } catch (error) {
        // 4. Manejo de errores
        console.error('Error al crear los boletines:', error);
        alert('❌ Error al crear los boletines. Revisa la consola.');
    }
};

</script>

<template>
    <AppLayout>
        <header class="mb-8 p-4 bg-white shadow-md rounded-lg">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">
                Creación de Boletines
            </h1>
            <h2 class="text-xl font-semibold text-indigo-700">
                Proyecto: {{ props.project.title }}
            </h2>
        </header>

        <section class="mb-10 p-6 bg-indigo-50 border-l-4 border-indigo-500 rounded-lg shadow-inner">
            <h3 class="text-lg font-bold text-indigo-800 mb-3">
                Creación Masiva
            </h3>
            <p class="text-sm text-gray-600 mb-4">
                Usa esta opción para generar automáticamente los boletines de **todos** los estudiantes de esta sección.
            </p>
            <button @click="createAllBoletines" class="
                    text-white bg-indigo-600 border-2 border-indigo-600
                    hover:bg-indigo-700 hover:border-indigo-700
                    font-medium rounded-lg text-sm px-6 py-2.5 text-center
                    transition duration-150 ease-in-out
                ">
                Crear TODOS los Boletines Ahora
            </button>
        </section>

        <section class="mt-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
                Estudiantes Individuales
            </h3>

            <StudentTicketTable :students="props.students" :projectId="props.project.id" />

        </section>

    </AppLayout>
</template>