<template>
    <div class="date-input-container">
        <label :for="props.id" class="date-label">Selecciona una fecha:</label>
        <input type="date" ref="myDateInput" :id="props.id"
            class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg block w-full p-2.5 mt-2"
            :min="today" required />
        <p v-if="error" class="text-[0.75rem] text-red-700">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, defineProps, defineEmits } from 'vue';

const myDateInput = ref(null);

//const data = ref(<string | null>(null));

onMounted(() => {
    // Verificamos que el ref tenga un valor (es decir, el elemento HTML)
    if (myDateInput.value) {
        myDateInput.value.addEventListener('change', (event) => {
            const selectedDate = event.target.value;
            console.log('Fecha seleccionada:', selectedDate);

            // Aquí puedes agregar tu lógica de validación
            // Ejemplo: si es un fin de semana
            const dateObject = new Date(selectedDate);
            const dayOfWeek = dateObject.getDay(); // 0 = Domingo, 6 = Sábado

            console.log('Día de la semana:', dayOfWeek);

            if (dayOfWeek === 5 || dayOfWeek === 6) {
                error.value = 'No se puede seleccionar un dia que sea fin de semana.';
                //props.modelValue = null; // Borrar la selección
            }
        });
    }
});

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    isWorkdayOnly: {
        type: Boolean,
        default: false,
    },

});

// Definición de los eventos emitidos por el componente
const emit = defineEmits(['update:modelValue']);

const error = ref<string | null>(null);
const today = ref<string>('');

// Lógica para obtener la fecha de hoy
const setToday = () => {
    const date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    today.value = `${year}-${month}-${day}`;
};

// Hook del ciclo de vida para inicializar el componente
onMounted(() => {
    setToday();
});
</script>

<style scoped>
/* Estilos del componente, iguales al ejemplo anterior */
.date-input-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
    font-family: sans-serif;
    max-width: 300px;
}

.date-label {
    font-weight: 600;
    color: #333;
}

.date-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}
</style>
