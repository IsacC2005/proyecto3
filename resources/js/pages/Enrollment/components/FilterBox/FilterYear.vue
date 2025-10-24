<script setup lang="ts">
import { ref, computed } from 'vue';

const props = defineProps<{ schoolYear: string }>()

const emits = defineEmits(['filterYear']);

const dateActual = new Date().getFullYear();
const initialStartYear = parseInt(props.schoolYear.split('-')[0]);
const selectedStartYear = ref(initialStartYear);

const selectedSchoolYear = computed<string>(() => {
    const startYear = selectedStartYear.value;
    const endYear = startYear + 1;
    return `${startYear}-${endYear}`;
});

const incrementYear = () => {
    selectedStartYear.value += 1;
    emits('filterYear', selectedSchoolYear.value);
};

const decrementYear = () => {
    selectedStartYear.value -= 1;
    emits('filterYear', selectedSchoolYear.value);
};

const isIncrementDisabled = computed(() => {
    return selectedStartYear.value >= dateActual;
});

</script>

<template>
    <div
        class="p-4 bg-white shadow-xl rounded-2xl transition duration-300 transform hover:scale-[1.02] min-w-[280px] flex flex-col items-center">
        <label class="block mb-3 text-sm font-bold text-gray-700">
            Ciclo Escolar
        </label>

        <div class="flex items-center space-x-4">

            <!-- Botón de Decremento -->
            <button @click="decrementYear"
                class="p-2 w-10 h-10 bg-gray-200 text-gray-800 rounded-full hover:bg-primary/80 hover:text-white transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                aria-label="Anterior ciclo escolar">
                <!-- Icono SVG de flecha izquierda -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-5 h-5 mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <!-- Display del Año -->
            <div class="text-3xl font-extrabold text-blue-900 min-w-[120px] text-center p-2 border-b-2 border-primary">
                {{ selectedSchoolYear }}
            </div>

            <button @click="incrementYear" :disabled="isIncrementDisabled"
                class="p-2 w-10 h-10 bg-gray-200 text-gray-800 rounded-full hover:bg-primary/80 hover:text-white transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                aria-label="Siguiente ciclo escolar" :class="{ 'opacity-50 cursor-not-allowed': isIncrementDisabled }">
                <!-- Icono SVG de flecha derecha -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-5 h-5 mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>
</template>
