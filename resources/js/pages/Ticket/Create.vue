<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { LearningProject, Student } from '@/types/dtos';
import StudentTicketTable from './Components/StudentTicketTable.vue';
import axios from 'axios';
import { onMounted, onUnmounted, ref } from 'vue';
import ProgressCreateLot from './Components/ProgressCreateLot.vue';

// --- Tipos y Props ---
const props = defineProps<{
    project: LearningProject,
    students: Student[]
}>();

// --- Estado de Progreso ---
const progress = ref(0);
const statusMessage = ref('A la espera de iniciar la creación masiva.');
const isFinished = ref(false);
const isProcessing = ref(false);
const isVisibleCarge = ref(false);
let intervalId: any = null;

// --- Funciones de Polling ---
const fetchProgress = async () => {
    try {
        const response = await axios.get(`/tickets/storeLot/progress/${props.project.id}`);
        const data = response.data;

        progress.value = data.percentage || 0;
        statusMessage.value = data.message || 'Procesando...';
        isFinished.value = data.finished;

        const hora = new Date()
        console.log(hora)

        if (isFinished.value) {
            clearInterval(intervalId); // Detener el polling al finalizar
        }

    } catch (error) {
        console.error("Error al obtener el progreso:", error);
        clearInterval(intervalId);
        isProcessing.value = false;
        statusMessage.value = '❌ Error de conexión. Revisa la consola.';
    }
};

const startPolling = () => {
    if (intervalId) {
        clearInterval(intervalId);
    }
    intervalId = setInterval(fetchProgress, 6000);
    fetchProgress();
    isProcessing.value = true;
    isVisibleCarge.value = true;
}

// --- Función de Creación Masiva ---
const createAllBoletines = async () => {
    if (isProcessing.value) return;

    progress.value = 0;
    statusMessage.value = 'Iniciando la creación de boletines...';
    isFinished.value = false;

    try {
        const response = await axios.post(`/tickets/storeLot/${props.project.id}`);
        console.log('Solicitud de creación enviada:', response.data);

        //  Iniciar el Polling para monitorear
        startPolling();

    } catch (error) {
        console.error('Error al iniciar la creación de boletines:', error);
        alert('❌ Error al iniciar la creación. Revisa la consola.');
        isProcessing.value = false;
    }
};

onMounted(() => {
    fetchProgress().then(() => {
        if (progress.value > 0 && isFinished.value === false) {
            startPolling();
        }
    });
})

// --- Limpieza al desmontar ---
onUnmounted(() => {
    if (intervalId) {
        clearInterval(intervalId);
    }
});
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
            <button @click="createAllBoletines" :disabled="isProcessing" :class="{
                'opacity-50 cursor-not-allowed': isProcessing,
                'text-white bg-indigo-600 border-2 border-indigo-600 hover:bg-indigo-700 hover:border-indigo-700': !isProcessing,
                'bg-gray-400 border-gray-400': isProcessing
            }" class="
                    font-medium rounded-lg text-sm px-6 py-2.5 text-center
                    transition duration-150 ease-in-out
                ">
                <span v-if="isProcessing">Procesando... ({{ progress }}%)</span>
                <span v-else-if="isFinished">¡Boletines Creados! Volver a Crear</span>
                <span v-else>Crear TODOS los Boletines Ahora</span>
            </button>
        </section>

        <div :class="{ hidden: !isVisibleCarge }">
            <ProgressCreateLot :statusMessage="statusMessage" :progress="progress" :isFinished="isFinished"
                :isProcessing="isProcessing" />
        </div>


        <section class="mt-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
                Estudiantes Individuales
            </h3>
            <StudentTicketTable :students="props.students" :projectId="props.project.id" />
        </section>

    </AppLayout>
</template>