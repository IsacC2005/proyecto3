<template>
    <div class="mt-3 max-w-80 flex flex-col gap-0.5 font-sans-serif">
        <Label :for="props.id">Selecciona una fecha:</Label>
        <input type="date" @input="emit('update:modelValue', new Date($event.target?.value))" v-model="DateSelect"
            ref="myDateInput" :id="props.id"
            class="bg-input border border-muted-foreground text-foreground text-sm rounded-lg block w-full p-2.5 mt-2"
            :min="today" required />
        <p v-if="error" class="text-[0.75rem] text-red-700">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
import Label from '@/components/ui/label/Label.vue';
import { ref, onMounted, defineProps, defineEmits } from 'vue';
import { useAlertData } from '@/store/ModalStore';
import { Alert } from '@/types';

const alert = useAlertData();
const { showAlert } = alert;

const alertDataMessage: Alert = {
    isOpen: true,
    title: '🚫¡Error!',
    description: 'La fecha que has seleccionado es fin de semana',
    message: 'No puedes seleccionar un dia que sea fin de semana, selecciona otra fecha',
    code: 0
}

const myDateInput = ref(null);
const DateSelect = ref(null);

onMounted(() => {

    setToday();
    // Verificamos que el ref tenga un valor (es decir, el elemento HTML)
    if (myDateInput.value) {
        myDateInput.value.addEventListener('change', (event) => {
            const selectedDate = event.target.value;

            const dateObject = new Date(selectedDate);
            const dayOfWeek = dateObject.getDay(); // 0 = Domingo, 6 = Sábado

            if (dayOfWeek === 5 || dayOfWeek === 6) {
                showAlert(alertDataMessage);
                error.value = 'No se puede seleccionar un dia que sea fin de semana.';
                DateSelect.value = null;
            } else {
                emit('update:modelValue', DateSelect);
                error.value = null;
            }
        });
    }
});

const props = defineProps({
    modelValue: {
        type: Object as () => Date,
        required: true,
    },
    id: {
        type: String,
        required: true,
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
</script>

<style scoped>
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
