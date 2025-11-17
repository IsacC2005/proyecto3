<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from "@inertiajs/vue3";
import AppLayout from '@/layouts/AppLayout.vue';
import { Student, ReportNote } from '@/types/dtos';
import ShowReportNoteCard from './Components/ShowReportNoteCard.vue';
import ShowReportNoteHead from './Components/ShowReportNoteHead.vue';
import ShowReportNoteInfoStudent from './Components/ShowReportNoteInfoStudent.vue'

// Definición de Props
const props = defineProps<{
    data: ReportNote | null
    student: Student
}>()

const form = useForm({
    id: props.data?.id ?? 0,
    average: props.data?.average ?? '',
    content: props.data?.content ?? '',
    suggestions: props.data?.suggestions ?? '',
    studentName: props.data?.studentName ?? '',
    studentSurName: props.data?.studentSurName ?? '',
    learningProjectId: props.data?.learningProjectId ?? 0,
    studentId: props.data?.studentId ?? 0
})

const formIa = useForm({})

// --- Estados Reactivos para Edición y Carga ---
// Variables para controlar el estado de edición
const isAverageEditing = ref(false);
const isContentEditing = ref(false);

// Variables para almacenar los valores editables temporalmente
const editableAverage = ref(props.data?.average || ''); // Inicializa con el valor existente o 0
const editableContent = ref(props.data?.content || ''); // Inicializa con el valor existente o cadena vacía

// Variables para el estado de carga/procesamiento (para los botones de IA)
const isProcessing = ref(false); // Estado de carga para cualquier operación (generar/regenerar)

// --- Lógica de Manejo de Edición ---

/**
 * Inicia la edición del promedio.
 */
const startAverageEdit = () => {
    // Si hay errores previos, se limpian al iniciar la edición
    if (form.errors.average) {
        form.clearErrors('average');
    }
    isAverageEditing.value = true;
};

/**
 * Cancela y restablece la edición del promedio.
 */
const cancelAverageEdit = () => {
    editableAverage.value = props.data?.average || ''; // Restablece al valor original
    isAverageEditing.value = false;
    form.clearErrors('average'); // Limpia errores al cancelar
};

/**
 * Guarda el promedio modificado.
 */
const saveAverage = () => {

    form.average = editableAverage.value;

    // Usamos el callback onSuccess para limpiar el estado de edición solo si fue exitoso
    form.patch(`/tickets/average/${props.data?.id}`, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            console.log('Guardando nuevo promedio:', editableAverage.value);
            isAverageEditing.value = false;
        },
        onError: (errors) => {
            console.error('Error al guardar promedio:', errors);
        }
    });
};

/**
 * Inicia la edición del contenido.
 */
const startContentEdit = () => {
    if (form.errors.content) {
        form.clearErrors('content');
    }
    isContentEditing.value = true;
};

/**
 * Cancela y restablece la edición del contenido.
 */
const cancelContentEdit = () => {
    editableContent.value = props.data?.content || ''; // Restablece al valor original
    isContentEditing.value = false;
    form.clearErrors('content'); // Limpia errores al cancelar
};

/**
 * Guarda el contenido modificado.
 */
const saveContent = () => {
    form.content = editableContent.value;

    form.patch(`/tickets/content/${props.data?.id}`, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            console.log('Guardando nuevo contenido:', editableContent.value);
            isContentEditing.value = false;
        },
        onError: (errors) => {
            console.error('Error al guardar contenido:', errors);
        }
    });
};

/**
 * @param type
 */
const handleAIRun = (type: 'generate' | 'regenerate') => {

    formIa.patch(`/tickets/recreate/${props.data?.id}`, {
        only: ['data', 'student'],
    });
    //if (isProcessing.value) return;

    //isProcessing.value = true;
    //console.log(`Ejecutando ${type} con IA...`);

    // NOTA: Esta llamada debe ser reemplazada por una llamada real a Inertia o Axios
    // que devuelva el contenido generado o dispare un evento de recarga.

    // Simulación de llamada a API/proceso de IA
    // setTimeout(() => {
    //     isProcessing.value = false;
    //     console.log('Proceso de IA terminado.');
    //     // Si fuera 'generate', aquí harías una petición para crear el reporte
    //     // Si fuera 'regenerate', harías una petición para actualizar el contenido
    // }, 2000);
};


const literals = ['A', 'B', 'C', 'D', 'E', 'F'];

</script>

<template>
    <AppLayout>
        <ShowReportNoteCard>
            <ShowReportNoteHead :studentName="props.student.name" :studentId="props.student.id" />

            <div class="content-card bg-white p-6 sm:p-8 rounded-xl shadow-lg">
                <ShowReportNoteInfoStudent :student="props.student" />

                <div v-if="props.data" class="space-y-8 mt-6">

                    <!-- Sección de Literal (Promedio) y Edición -->
                    <div class="p-4 rounded-xl" :class="{
                        'bg-red-50 border border-red-300': form.errors.average,
                        'bg-secondary-gray': !form.errors.average
                    }">
                        <div class="flex items-center space-x-4">
                            <span class="text-2xl font-bold text-dark-text">Literal:</span>

                            <div class="flex flex-col">
                                <select v-model="editableAverage" :disabled="!isAverageEditing" :class="[
                                    'text-3xl font-extrabold appearance-none bg-white',
                                    isAverageEditing ? 'border-primary-blue ring-2 ring-primary-blue shadow-md' : 'border-transparent',
                                    form.errors.average ? 'border-red-500 ring-2 ring-red-500' : '',
                                    'w-32 p-2 rounded-lg transition duration-150 cursor-pointer'
                                ]">
                                    <option v-for="(literal, index) in literals" :key="index" :value="literal">{{
                                        literal }}
                                    </option>
                                </select>
                                <span v-if="form.errors.average" class="text-xs text-red-600 mt-1 font-medium">
                                    {{ form.errors.average }}
                                </span>
                            </div>

                            <div class="flex space-x-2 ml-auto">
                                <button v-if="!isAverageEditing" @click="startAverageEdit"
                                    class="p-3 bg-gray-200 hover:bg-primary-blue hover:text-white rounded-full text-gray-700 transition duration-150 shadow-sm"
                                    title="Editar Literal">
                                    <!-- Icono de Editar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd"
                                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <button v-if="isAverageEditing" @click="saveAverage" :disabled="form.processing"
                                    class="p-3 bg-green-600 hover:bg-green-700 rounded-full text-white transition duration-150 shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    title="Guardar Literal">
                                    <!-- Icono de Guardar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <button v-if="isAverageEditing" @click="cancelAverageEdit" :disabled="form.processing"
                                    class="p-3 bg-red-500 hover:bg-red-600 rounded-full text-white transition duration-150 shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    title="Cancelar Edición">
                                    <!-- Icono de Cancelar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Contenido y Edición -->
                    <div class="bg-white p-4 border rounded-xl shadow-inner" :class="{
                        'border-red-500 ring-1 ring-red-500': form.errors.content,
                        'border-gray-200': !form.errors.content
                    }">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg text-dark-text">Contenido del Reporte:</h3>
                            <div class="flex space-x-2">
                                <button v-if="!isContentEditing" @click="startContentEdit"
                                    class="p-2 bg-gray-200 hover:bg-primary-blue hover:text-white rounded-full text-gray-700 transition duration-150 shadow-sm"
                                    title="Editar Contenido">
                                    <!-- Icono de Editar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd"
                                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <button v-if="isContentEditing" @click="saveContent" :disabled="form.processing"
                                    class="p-2 bg-green-600 hover:bg-green-700 rounded-full text-white transition duration-150 shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    title="Guardar Contenido">
                                    <!-- Icono de Guardar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <button v-if="isContentEditing" @click="cancelContentEdit" :disabled="form.processing"
                                    class="p-2 bg-red-500 hover:bg-red-600 rounded-full text-white transition duration-150 shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    title="Cancelar Edición">
                                    <!-- Icono de Cancelar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Mensaje de error para el contenido -->
                        <span v-if="form.errors.content" class="text-sm text-red-600 font-medium block mb-2">
                            {{ form.errors.content }}
                        </span>

                        <textarea v-if="isContentEditing" v-model="editableContent" rows="10" maxlength="2400" :class="[
                            'w-full text-gray-700 leading-relaxed border rounded-lg p-3 transition duration-150',
                            form.errors.content ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-primary-blue focus:border-primary-blue'
                        ]"></textarea>
                        <p v-else class="text-gray-700 leading-relaxed whitespace-pre-line p-3">{{ editableContent }}
                        </p>
                    </div>

                    <!-- Botón de Regenerar con IA -->
                    <button @click="handleAIRun('regenerate')"
                        :disabled="formIa.processing || isAverageEditing || isContentEditing"
                        class="w-full px-6 py-3 text-white font-semibold rounded-xl transition duration-300 transform shadow-md
                               bg-yellow-500 hover:bg-yellow-600 active:scale-95 disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center">
                        <span v-if="formIa.processing">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Regenerando con IA...
                        </span>
                        <span v-else>
                            <span class="text-xl mr-2">🔄</span> Re-generar Contenido (Usar IA)
                        </span>
                    </button>

                    <p v-if="props.data.suggestions" class="pt-2 text-sm text-gray-500 italic border-t border-gray-200">
                        Sugerencias Anexas: **{{ props.data.suggestions }}**
                    </p>
                </div>

                <!-- Contenido cuando AÚN NO ha sido generado -->
                <div v-else class="text-center p-8 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50">
                    <p class="text-xl font-medium text-dark-text mb-4">
                        ¡El boletín para **{{ props.student.name }}** aún no ha sido generado!
                    </p>
                    <p class="text-gray-600 mb-6">
                        Usa el botón de abajo para generar automáticamente el primer borrador del reporte de desempeño
                        usando Inteligencia Artificial.
                    </p>

                    <button @click="handleAIRun('generate')" :disabled="isProcessing"
                        class="px-8 py-3 text-white font-semibold rounded-xl transition duration-300 transform shadow-lg
                               bg-primary-blue hover:bg-blue-600 active:scale-95 disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center">
                        <span v-if="isProcessing">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generando con IA...
                        </span>
                        <span v-else>
                            <span class="text-xl mr-2">✨</span> Generar Contenido (Usar IA)
                        </span>
                    </button>
                </div>
            </div>
        </ShowReportNoteCard>
    </AppLayout>
</template>