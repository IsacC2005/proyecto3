<script setup lang="ts">
import { ref, watchEffect } from 'vue';
import { useQualitesStore } from "@/store/QualitiesStore"; // Asumo que usas el mismo store

const store = useQualitesStore();

const props = defineProps<{
    studentId: number,
    learningProjectId: number,
    isEvaluated: boolean // Estado inicial desde la prop
}>();

// Estado local para el checkbox, inicializado con la prop
const isLocalEvaluated = ref(props.isEvaluated);

// Sincronizar con la prop por si cambia de estudiante
watchEffect(() => {
    isLocalEvaluated.value = props.isEvaluated;
});

const toggleEvaluationStatus = () => {
    store.evaluateStatus(props.learningProjectId, props.studentId);
}
</script>

<template>
    <div class="flex items-center justify-end p-2 bg-gray-50 border-t border-gray-200">
        <label :for="`evaluated-${studentId}`" class="flex items-center space-x-2 cursor-pointer">
            <span class="text-sm font-medium text-gray-700">Evaluación Completa</span>
            <input type="checkbox" :id="`evaluated-${studentId}`" v-model="isLocalEvaluated"
                @change="toggleEvaluationStatus"
                class="form-checkbox h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" />
        </label>
    </div>
</template>