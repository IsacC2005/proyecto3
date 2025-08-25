<template>
    <div v-if="show" class="fixed inset-0 w-screen h-screen bg-black/80 z-50">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg p-6 max-w-sm w-full">
                <h2 class="text-lg font-bold mb-4">{{ Title }}</h2>
                <p class="mb-4">{{ Message }}</p>
                <button @click="closeModal" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, ref } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    Title: {
        type: String,
        default: 'Titulo para el modal'
    },
    Message: {
        type: String,
        default: 'Este es un mensaje del modal',
    },
    onClose: {
        type: Function,
        required: false,
        default: () => { console.log('Holaa') }
    },
});

// Define un evento para informar al padre que el modal debe cerrarse
const emit = defineEmits(['close']);

// Función para cerrar el modal
const closeModal = () => {


    props.onClose();

    emit('close');
};

</script>
