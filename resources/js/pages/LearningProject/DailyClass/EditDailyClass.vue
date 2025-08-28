<template>
    <AppLayout>
        <div class="p-4 sm:p-6 md:p-8 w-full max-w-4xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">
                Modificar Clase Diaria
            </h1>

            <form @submit.prevent="submit" class="bg-white rounded-lg shadow-md p-6 sm:p-8">
                <div class="mb-6">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                        Título de la Clase:
                    </label>
                    <input id="title" type="text" v-model="form.title"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        required>
                    <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">
                        {{ form.errors.title }}
                    </div>
                </div>

                <div class="mb-6">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">
                        Contenido:
                    </label>
                    <textarea id="content" v-model="form.content" rows="10"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        required></textarea>
                    <div v-if="form.errors.content" class="text-red-500 text-xs mt-1">
                        {{ form.errors.content }}
                    </div>
                </div>

                ---

                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Indicadores de Evaluación</h3>

                    <div v-for="(indicator, index) in form.indicators" :key="index"
                        class="flex items-center gap-4 mb-4">
                        <input type="text" v-model="indicator.title" placeholder="Ej: Resuelve problemas con código"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            required>
                        <button type="button" @click="removeIndicator(index)"
                            class="text-red-500 hover:text-red-700 transition-colors duration-200"
                            aria-label="Eliminar indicador">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                    <button type="button" @click="addIndicator"
                        class="flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Añadir Indicador
                    </button>
                </div>

                ---

                <div class="flex flex-col sm:flex-row items-center justify-between mt-8 gap-4">
                    <button type="submit" :disabled="form.processing"
                        class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span v-if="form.processing">Guardando...</span>
                        <button v-else @click="submit" method="put">
                            Actualizar Clase</button>
                    </button>
                    <button type="button" @click="cancel"
                        class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    dailyClass: {
        type: Object,
        required: true,
        validator: (value: any) => {
            return value.hasOwnProperty('id') && value.hasOwnProperty('title') && value.hasOwnProperty('content');
        }
    },
    updateUrl: {
        type: String,
        required: true
    },
    // Añadimos una prop para los indicadores existentes
    indicators: {
        type: Array as () => { description: string }[],
        default: () => [],
    }
});

// Inicializamos el formulario con los datos de la clase y los indicadores
const form = useForm({
    title: props.dailyClass.title,
    content: props.dailyClass.content,
    indicators: props.dailyClass.indicators, // Incluimos los indicadores
});

const submit = () => {
    form.put(`/daily-class/update/${props.dailyClass.id}`, {
        preserveScroll: true,
        preserveState: true,
    });
};

const cancel = () => {
    window.history.back();
};

// Función para añadir un nuevo indicador
const addIndicator = () => {
    form.indicators.push({ description: '' });
};

// Función para eliminar un indicador por su índice
const removeIndicator = (index: number) => {
    form.indicators.splice(index, 1);
};
</script>
