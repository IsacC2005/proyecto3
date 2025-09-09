<template>
    <div>
        <div>
            <slot name="activator"></slot>
        </div>

        <div v-if="showModal" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 flex justify-center items-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg p-6 m-4">
                <div class="flex justify-between items-center pb-3 border-b dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Crear Referente Teórico</h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitForm" class="mt-4">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del
                            Referente Teórico</label>
                        <input type="text" id="title" v-model="form.title" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label for="content"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Desarrollo</label>
                        <textarea id="content" v-model="form.content" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>

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

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="closeModal"
                            class="px-4 py-2 text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Crear Referente Teorico
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watchEffect } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

const showModal = ref(false);

const props = defineProps({
    projectId: {
        type: Number,
        required: true
    },
    open: {
        type: Boolean,
        required: true
    }
});

watchEffect(() => {
    showModal.value = props.open
})


const form = useForm({
    projectId: props.projectId,
    title: '',
    content: '',
    indicators: []
});

const emits = defineEmits(['classCreated', 'closeModal']);

const closeModal = () => {
    showModal.value = false;
    form.projectId = 0;
    form.title = '';
    form.content = '';
    form.indicators = [];
    emits('closeModal');
    addModalParamToUrl();
};

const addModalParamToUrl = () => {
    const url = new URL(window.location.href);
    url.searchParams.delete('modal');

    // Reemplazamos la URL actual sin añadir una nueva entrada al historial
    history.replaceState({}, '', url.toString());
};

const submitForm = () => {
    // Aquí se envía la solicitud a Laravel para crear la clase.
    // Usamos Inertia.post para enviar los datos.

    form.projectId = props.projectId;

    form.post(route('daily-class.create'), {
        onSuccess: () => {
            closeModal();
            // Emitimos un evento al componente padre para que sepa que la clase fue creada.
            emits('classCreated');
            // Opcional: Inertia refresca la página automáticamente al completar la petición,
            // pero si necesitas una acción específica, puedes emitir el evento.
        },
        onError: (errors) => {
            console.error('Error al crear la clase:', errors);
            // Manejar los errores de validación aquí, por ejemplo, mostrarlos al usuario.
        }
    });
};

const addIndicator = () => {
    form.indicators.push({ description: '' });
};

// Función para eliminar un indicador por su índice
const removeIndicator = (index: number) => {
    form.indicators.splice(index, 1);
};
</script>