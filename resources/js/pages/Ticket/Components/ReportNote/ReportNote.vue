<script setup lang="ts">
import { ref } from 'vue';
import { ReportNote } from '@/types/dtos';

const props = defineProps<{
    reportNote: ReportNote
}>()

const emit = defineEmits(['showDetails'])

// Definición de tipos para TypeScript
interface Report {
    id: number;
    average: string;
    content: string;
    suggestions: string;
    studentName: string;
    studentSurName: string;
    learningProjectId: number;
    studentId: number;
}

// Datos de ejemplo
const initialReports: Report[] = [
    { "id": 46, "average": "A", "content": "Maria es una estudiante amable y respetuosa que se integra activamente en el aula y demuestra una curiosidad innata por el aprendizaje. Con gran claridad, identifica los tres pasos principales del reciclaje y distingue con precisión entre materiales orgánicos e inorgánicos; además, reconoce los colores de los contenedores de reciclaje y su función, mostrando un progreso constante en esta área. Con entusiasmo, explora la importancia de reducir el consumo de recursos naturales y vincula eficazmente la acción de reciclar con sus beneficios ambientales. Asimismo, clasifica los desechos sólidos en los contenedores apropiados y contribuye activamente en la creación de objetos útiles a partir de material de desecho, exhibiendo un potencial prometedor en su participación, mientras maneja herramientas básicas de forma segura y eficiente. Demuestra un notable respeto por el medio ambiente al mantener su área limpia y desarrolla con compromiso sus habilidades para comunicar la importancia del proyecto de reciclaje. Asume con creciente responsabilidad el cuidado de los objetos creados y colabora de manera excelente con su equipo en las tareas asignadas, además de proponer ideas originales para la reducción del uso de plásticos o papel en el aula, destacando su creatividad e interés.", "suggestions": "", "studentName": "HURTADO MENDOZA HECTOR LUIS", "studentSurName": "", "learningProjectId": 4, "studentId": 35741 },
    { "id": 47, "average": "A", "content": "Maria es una estudiante amable y respetuosa, que siempre se muestra curiosa e interesada, participando activamente en todas las actividades. Ella identifica correctamente los tres pasos principales del ciclo de vida de los materiales y distingue con facilidad entre materiales orgánicos e inorgánicos. Además, profundiza su conocimiento sobre los colores de los contenedores de reciclaje y su función, y comienza a articular la relevancia de la reducción del consumo de recursos naturales, mientras relaciona la acción de reciclar con sus beneficios ambientales. En las actividades prácticas, organiza plenamente los desechos sólidos en los contenedores apropiados y muestra creciente entusiasmo en la elaboración de objetos útiles a partir de material de desecho, empleando herramientas básicas de forma segura y eficiente. Manifiesta respeto por el medio ambiente al mantener siempre limpia su área de trabajo y el entorno escolar, y está fortaleciendo su capacidad para comunicar la importancia del proyecto de reciclaje a sus compañeros y familiares. Asimismo, está desarrollando un sentido de compromiso en el cuidado de los objetos o espacios creados con material reutilizado, colabora activamente con su equipo en las tareas asignadas y formula ideas creativas para la reducción del uso de plásticos o papel en el aula.", "suggestions": "", "studentName": "HURTADO MENDOZA HECTOR LUIS", "studentSurName": "", "learningProjectId": 4, "studentId": 35741 }
];

// Estado reactivo (usando ref en lugar de useState de React)
const reports = ref<Report[]>(initialReports);
const modalOpen = ref(false);
const selectedReport = ref<Report | null>(null);

/**
 * Trunca el texto del contenido del boletín para la vista de tarjeta.
 * @param text - El contenido completo.
 * @param limit - Límite de caracteres.
 * @returns El texto truncado.
 */
const truncateText = (text: string, limit: number = 200): string => {
    if (!text) return "";
    return text.length > limit ? text.substring(0, limit) + "..." : text;
};

/**
 * Define los estilos de Tailwind para el promedio.
 * @param average - El promedio (ej. 'A', 'B').
 * @returns Clases CSS para el estilo.
 */
const getAverageStyles = (average: string): string => {
    const base = "font-bold text-sm px-3 py-1 rounded-full inline-block whitespace-nowrap";
    switch (average) {
        case 'A': return `${base} bg-green-100 text-green-700`;
        case 'B': return `${base} bg-yellow-100 text-yellow-700`;
        default: return `${base} bg-gray-100 text-gray-700`;
    }
};

/**
 * Maneja la acción de eliminación (simulada).
 * @param reportId - ID del boletín a eliminar.
 */
const handleDelete = (reportId: number): void => {
    // Simulación: Filtrar el reporte eliminado del estado
    reports.value = reports.value.filter(r => r.id !== reportId);
    console.log(`Boletín ${reportId} eliminado.`);
    // En un entorno real, aquí iría la llamada a la API de Laravel
};

/**
 * Cierra el modal de detalles.
 */
const closeModal = (): void => {
    modalOpen.value = false;
    selectedReport.value = null;
};

</script>

<template>
    <!-- Contenedor Principal con Estilos de Fondo y Padding -->

    <!-- Cabecera de la Aplicación -->

    <!-- Grid de Boletines (Responsive) -->


    <!-- Iteración sobre la lista de boletines -->
    <div
        class="bg-white shadow-xl hover:shadow-2xl transition-shadow duration-300 rounded-xl p-5 flex flex-col h-full border border-gray-100">
        <!-- Cabecera del Boletín (Nombre y Promedio) -->
        <div class="flex justify-between items-start mb-4 border-b pb-3">
            <h3 class="text-lg font-extrabold text-gray-800 leading-tight">
                {{ props.reportNote.studentName }}
            </h3>
            <span :class="getAverageStyles(props.reportNote.average)">
                Literal: {{ props.reportNote.average }}
            </span>
        </div>

        <!-- Contenido truncado -->
        <div class="flex-grow mb-4">
            <!-- line-clamp-4 es una clase de Tailwind para truncar en 4 líneas -->
            <p class="text-sm text-gray-600 line-clamp-4">
                {{ truncateText(props.reportNote.content, 200) }}
            </p>
        </div>

        <!-- Pie de la Tarjeta con Acciones -->
        <div
            class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0 sm:space-x-2 pt-3 border-t">
            <button @click="emit('showDetails')"
                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg text-sm">
                Ver Detalles (ID: {{ props.reportNote.id }})
            </button>
            <button @click="handleDelete(props.reportNote.id)"
                class="w-full sm:w-auto bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out text-sm">
                Eliminar
            </button>
        </div>
    </div>

    <!-- Mensaje si no hay boletines -->

    <!-- Modal para Ver Detalles -->
    <div v-if="modalOpen && selectedReport"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <!-- Contenedor del Modal -->
        <div
            class="bg-white rounded-xl shadow-2xl m-auto w-full max-h-[90vh] overflow-y-auto transform transition-all scale-100">

            <!-- Cabecera del Modal -->
            <div class="p-6 border-b flex justify-between items-center sticky top-0 bg-white rounded-t-xl">
                <h2 class="text-2xl font-bold text-gray-900">
                    Detalles del Boletín
                </h2>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <!-- Icono de Cierre (X) -->
                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Contenido Completo del Reporte -->
            <div class="p-6 space-y-4">
                <p class="text-lg font-semibold text-indigo-600">
                    Estudiante: {{ selectedReport.studentName }}
                </p>
                <p class="text-sm font-medium text-gray-700">
                    ID: {{ selectedReport.id }} | Promedio: <span class="font-bold">{{ selectedReport.average
                    }}</span>
                </p>
                <hr class="my-4" />
                <h3 class="text-md font-bold text-gray-800 mb-2">Contenido Completo:</h3>
                <!-- whitespace-pre-wrap respeta saltos de línea y hace wrap automáticamente -->
                <p class="text-gray-600 whitespace-pre-wrap">{{ selectedReport.content }}</p>

                <template v-if="selectedReport.suggestions">
                    <hr class="my-4" />
                    <h3 class="text-md font-bold text-gray-800 mb-2">Sugerencias:</h3>
                    <p class="text-gray-600 whitespace-pre-wrap">{{ selectedReport.suggestions }}</p>
                </template>
            </div>

            <!-- Pie del Modal -->
            <div class="p-4 border-t flex justify-end">
                <button @click="closeModal"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-150">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

</template>
