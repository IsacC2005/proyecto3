<template>
    <form @submit.prevent="submitForm" class="mt-4">
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
            <input type="text" id="title" v-model="form.title" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contenido</label>
            <textarea id="content" v-model="form.content" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
        </div>
        <div class="flex justify-end space-x-2">
            <button type="button" @click="closeModal"
                class="px-4 py-2 text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors">
                Cancelar
            </button>
            <button type="submit"
                class="px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Crear Clase
            </button>
        </div>
    </form>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = ref({
    title: '',
    content: ''
});

const submitForm = () => {
    // Aquí se envía la solicitud a Laravel para crear la clase.
    // Usamos Inertia.post para enviar los datos.
    router.post(route('clases.store'), form.value, {
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
</script>