<script setup lang="ts">
import { ref, watch } from 'vue';
import { useEvaluateStore } from '@/store/EvaluteReferentStore';

let timeoutId: ReturnType<typeof setTimeout> | null = null;
const DEBOUNCE_DELAY = 100; // Tiempo de espera en milisegundos

// Función que envuelve la lógica del filtro con el retraso
const debouncedFilter = (value: string) => {
    if (timeoutId) {
        clearTimeout(timeoutId);
    }
    timeoutId = setTimeout(() => {
        evaluateReferent.filterByName(value);
    }, DEBOUNCE_DELAY);
};
// Inicializar el store
const evaluateReferent = useEvaluateStore();

// Estado local para el término de búsqueda
const searchTerm = ref('');
// Estado para controlar si el campo está abierto (expandido)
const isOpen = ref(false);

/**
 * Función que llama al store para filtrar.
 * Se utiliza debounce para evitar llamar al filtro en cada pulsación de tecla,
 * lo que optimiza el rendimiento.
 */

// Observar los cambios en searchTerm y llamar a la función de filtro con debounce
watch(searchTerm, (newValue) => {
    debouncedFilter(newValue);
});

// Función para abrir el campo de búsqueda
const openFilter = () => {
    isOpen.value = true;
};

// Función para cerrar el campo si está vacío
const closeFilter = () => {
    // Si el campo de búsqueda está vacío, lo cerramos
    if (!searchTerm.value) {
        isOpen.value = false;
    }
};

// Función para limpiar la búsqueda y cerrar
const clearSearch = () => {
    searchTerm.value = '';
    isOpen.value = false;
    // La función watch se encargará de llamar a debouncedFilter('')
};
</script>

<template>
    <div :class="[
        'sticky z-50 transition-all duration-300 ease-in-out',
        // Posicionamiento responsivo (parte inferior derecha)
        'top-16 right-1 sm:top-16 sm:right-1',
        // Estilos de la burbuja
        'shadow-2xl rounded-full mb-4 bg-white border border-gray-200',
        // Tamaño y estilos al estar abierto vs. cerrado
        isOpen ? 'w-full max-w-sm h-12' : 'w-12 h-12 flex items-center justify-center cursor-pointer hover:bg-gray-50'
    ]" @click="openFilter">

        <div v-if="!isOpen" class="flex items-center justify-center w-full h-full"
            aria-label="Abrir filtro de búsqueda">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <div v-else class="flex w-full h-full">
            <input type="text" v-model="searchTerm" @blur="closeFilter" placeholder="Filtrar por nombre..."
                class="flex-grow h-full px-4 rounded-l-full border-none focus:ring-indigo-500 focus:border-indigo-500 text-gray-800"
                autofocus />

            <button @click="clearSearch"
                class="flex items-center justify-center w-12 h-full rounded-r-full bg-indigo-600 text-white hover:bg-indigo-700 transition-colors duration-200"
                aria-label="Limpiar y cerrar búsqueda">
                <svg v-if="searchTerm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</template>