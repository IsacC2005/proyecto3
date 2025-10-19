<script setup lang="ts">
import { type qualitie, useQualitesStore } from "@/store/QualitiesStore";
import { ref, watchEffect } from "vue";

const store = useQualitesStore();

const props = defineProps<{
    qualities: qualitie[],
    learningProjectId: number,
    studentId: number,
    studentQualitieIds: number[]
}>()

const localQualities = ref<number[]>([]);

watchEffect(() => {
    localQualities.value = [...(props.studentQualitieIds || [])];
});

const CheckIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-white">
    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.052-.143Z" clip-rule="evenodd" />
</svg>`;

const isQualitieSelected = (qualitieId: number): boolean => {
    return localQualities.value.includes(qualitieId);
};

const save = (id: number) => {
    const index = localQualities.value.indexOf(id);
    if (index === -1) {
        localQualities.value.push(id);
    } else {
        localQualities.value.splice(index, 1);
    }

    store.evaluate(id, props.learningProjectId, props.studentId);
}
</script>

<template>
    <div class="space-y-3">
        <div v-for="qualitie in props.qualities" :key="qualitie.id" class="group flex items-center justify-between p-3 rounded-xl border border-gray-200 bg-white 
                hover:bg-indigo-50 transition-colors duration-200 cursor-pointer">

            <!-- Contenedor del Label y el Checkbox para hacer toda la fila un área de toque -->
            <label :for="`qualitie-${qualitie.id}`" class="flex-grow flex items-center justify-between text-gray-700">

                <!-- Nombre de la cualidad (Texto principal) -->
                <span class="text-base font-medium transition-colors duration-200 group-hover:text-indigo-700">
                    {{ qualitie.name }}
                </span>

                <!-- Checkbox Personalizado (Área de toque grande) -->
                <div class="relative flex items-center h-8 w-8 ml-4">
                    <input type="checkbox" :id="`qualitie-${qualitie.id}`" @change="save(qualitie.id)"
                        class="h-8 w-8 cursor-pointer opacity-0 absolute z-10" />
                    <!-- Reemplazo visual del Checkbox: USA el estado local reactivo -->
                    <div class="w-6 h-6 rounded-full border-2 border-indigo-400 bg-white 
                                flex items-center justify-center transition-all duration-200 ease-in-out 
                                group-hover:bg-indigo-200 group-hover:border-indigo-600">
                        <!-- El checkmark ahora se renderiza si el ID está en el array reactivo -->
                        <div v-if="isQualitieSelected(qualitie.id)"
                            class="w-full h-full rounded-full bg-indigo-600 flex items-center justify-center"
                            v-html="CheckIcon">
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>
</template>
