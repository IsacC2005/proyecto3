<template>
    <AppLayout>
        <Heading title="Modificar clase diaria"
            description="Las clases una ves evaluadas no pueden ser modificadas, debes registrar lo mejor posible tus clases diarias para no tener que modificarlas en el futuro">
        </Heading>
        <div class="p-4 sm:p-6 md:p-8 w-full max-w-4xl mx-auto">
            <FormDailyClass :daily-class="props.dailyClass">
                <template #submit="{ processing }">

                    <div class="flex flex-col sm:flex-row items-center justify-between mt-8 gap-4">
                        <button type="submit" :disabled="processing"
                            class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span v-if="processing">Guardando...</span>
                            <span v-else>
                                Actualizar Clase</span>
                        </button>

                        <button type="button" @click="cancel"
                            class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                            Cancelar
                        </button>
                    </div>
                </template>
            </FormDailyClass>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import FormDailyClass from './components/FormDailyClass/FormDailyClass.vue';
import { DailyClass } from '@/types/dtos';

const props = defineProps<{
    dailyClass: DailyClass
}>()

// const props = defineProps({
//     dailyClass: {
//         type: Object,
//         required: true,
//         validator: (value: any) => {
//             return value.hasOwnProperty('id') && value.hasOwnProperty('title') && value.hasOwnProperty('content');
//         }
//     },
//     updateUrl: {
//         type: String,
//         required: true
//     },
//     // Añadimos una prop para los indicadores existentes
//     indicators: {
//         type: Array as () => { description: string }[],
//         default: () => [],
//     }
// });

// Inicializamos el formulario con los datos de la clase y los indicadores
const form = useForm({
    title: props.dailyClass.title,
    content: props.dailyClass.content,
    indicators: props.dailyClass.indicators, // Incluimos los indicadores
});

const cancel = () => {
    window.history.back();
};

// Función para añadir un nuevo indicador
const addIndicator = () => {
    form.indicators.push({ description: '' });
};

// Función para eliminar un indicador por su índice
const removeIndicator = (index: number) => {
    form.indicators.splice(index, 1);
};
</script>
