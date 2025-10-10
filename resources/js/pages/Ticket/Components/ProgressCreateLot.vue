<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
    progress: {
        type: Number,
        default: 0
    },
    statusMessage: {
        type: String,
        default: ''
    },
    isFinished: {
        type: Boolean,
        default: false
    },
    // Añadimos la prop para mejorar la retroalimentación visual
    isProcessing: {
        type: Boolean,
        default: false
    }
});

// Calcula la clase de color y el mensaje principal
const progressStyle = computed(() => {
    // Si la tarea ha finalizado, el color es verde
    if (props.isFinished) {
        return 'bg-green-500';
    }
    // Si está en proceso, un color más activo (azul o índigo)
    else if (props.isProcessing) {
        return 'bg-indigo-500';
    }
    // Si aún no ha iniciado o tiene 0% (estado inicial), un color sutil
    else {
        return 'bg-gray-400';
    }
});

const containerStyle = computed(() => {
    if (props.isFinished) {
        return 'border-green-400 bg-green-50';
    } else if (props.isProcessing) {
        return 'border-indigo-400 bg-indigo-50';
    } else {
        return 'border-gray-300 bg-white';
    }
});

const icon = computed(() => {
    if (props.isFinished) {
        return '✅'; // Checkmark
    } else if (props.isProcessing) {
        return '⚙️'; // Gear (Procesando)
    } else {
        return '🕒'; // Reloj (A la espera)
    }
})

</script>

<template>
    <div :class="containerStyle" class="
            p-5 rounded-lg shadow-lg border-l-4 
            transition-all duration-300 ease-in-out
        ">
        <div class="flex items-center mb-4">
            <span class="text-2xl mr-3">{{ icon }}</span>
            <h3 class="text-xl font-bold text-gray-800">
                Estado del Proceso de Creación Masiva
            </h3>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-3 mb-2 overflow-hidden">
            <div :class="progressStyle" :style="{ width: props.progress + '%' }"
                class="h-3 transition-all duration-500 ease-out"></div>
        </div>

        <div class="flex justify-between items-center text-sm font-medium">
            <span
                :class="props.isFinished ? 'text-green-700' : (props.isProcessing ? 'text-indigo-700' : 'text-gray-500')">
                {{ Math.floor(props.progress) }}% Completado
            </span>

            <p :class="props.isFinished ? 'text-green-800 font-semibold' : 'text-gray-600'" class="ml-4 truncate">
                {{ props.statusMessage || 'Inicializando...' }}
            </p>
        </div>

        <p v-if="props.isFinished" class="mt-3 text-sm font-bold text-green-700 p-2 bg-green-100 rounded">
            🎉 ¡La tarea de creación de boletines ha finalizado con éxito!
        </p>

        <p v-else-if="props.isProcessing" class="mt-3 text-sm font-medium text-indigo-700">
            ⏳ El proceso está en curso. No cierres esta página.
        </p>
    </div>
</template>