<script setup lang="ts">
import { ref, watch } from 'vue';
import Select from '@/components/ui/Select/Select.vue';
import Label from '@/components/ui/label/Label.vue';

const grades = [
    { id: null, name: 'Todos' },
    { id: 1, name: 'Primer Grado' },
    { id: 2, name: 'Segundo Grado' },
    { id: 3, name: 'Tercer Grado' },
    { id: 4, name: 'Cuarto Grado' },
    { id: 5, name: 'Quinto Grado' },
    { id: 6, name: 'Sexto Grado' },
];

// Estado reactivo para el grado seleccionado
const selectedGrade = ref(grades[0]); // Por defecto, se selecciona el primer grado

// Define el evento que se emitirá al componente padre
const emits = defineEmits(['filterGrade']);

// Observa el cambio en 'selectedGrade' y emite el valor
watch(selectedGrade, (newValue) => {
    emits('filterGrade', newValue);
});
</script>

<template>
    <Label class="relative w-50 m-2 p-2 pb-4 flex flex-col items-center border border-t-0 border-x-0 border-b-gray-400">
        <span class="absolute -bottom-1.5 left-0 px-1 bg-background text-[0.8rem] text-gray-400">Grado</span>
        <Select @select="selectedGrade = $event" :options="grades" :name="selectedGrade.name" />
    </Label>
</template>