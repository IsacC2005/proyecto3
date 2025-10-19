<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { qualitiesType } from '@/store/QualitiesStore'; // Asegúrate de que esta ruta sea correcta
import Qualities from './Qualities.vue';

// Ícono SVG de flecha (para indicar estado abierto/cerrado)
const ChevronDownIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
</svg>`;

const props = defineProps<{
    qualities: qualitiesType[],
    learningProjectId: number,
    studentId: number,
    studentQualitieIds: number[]
}>()

const isVisible = ref<Record<number, boolean>>({});

onMounted(() => {
    // Inicializar todos como cerrados
    props.qualities.forEach(qualitieType => {
        isVisible.value[qualitieType.id] = false
    });
})

const showChange = (id: number) => {
    // Cierra todos los demás y alterna el estado del ID seleccionado
    const currentState = isVisible.value[id];

    // Cierra todos
    props.qualities.forEach(element => {
        isVisible.value[element.id] = false;
    });

    // Alterna el que se acaba de tocar
    isVisible.value[id] = !currentState;
}

const isSectionVisible = (id: number): boolean => {
    return isVisible.value[id] || false;
}

</script>

<template>
    <div class="space-y-3 mt-4">
        <template v-for="type in props.qualities" :key="type.id">
            <div class="w-full border rounded-lg overflow-hidden shadow-sm">
                <!-- Botón de Categoría (Acordeón Header) -->
                <button
                    class="w-full flex items-center justify-between py-3 px-4 text-left font-medium text-white transition duration-300 ease-in-out"
                    :class="[
                        isSectionVisible(type.id)
                            ? 'bg-indigo-600 hover:bg-indigo-700'
                            : 'bg-gray-700 hover:bg-gray-600'
                    ]" @click="showChange(type.id)">
                    <span class="text-lg">{{ type.name }}</span>
                    <!-- Ícono de flecha que rota -->
                    <span class="transition-transform duration-300" :class="{ 'rotate-180': isSectionVisible(type.id) }"
                        v-html="ChevronDownIcon">
                    </span>
                </button>

                <!-- Contenido del Acordeón -->
                <div v-show="isSectionVisible(type.id)"
                    class="p-4 bg-gray-50 border-t border-gray-200 transition-all duration-300 ease-in-out">
                    <Qualities :qualities="type.qualities" :learning-project-id="props.learningProjectId"
                        :studentId="props.studentId" :studentQualitieIds="props.studentQualitieIds" />
                </div>
            </div>
        </template>
    </div>
</template>
