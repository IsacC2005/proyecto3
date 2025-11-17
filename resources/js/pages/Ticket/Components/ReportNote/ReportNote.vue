<script setup lang="ts">
import { ref } from 'vue';
import { ReportNote } from '@/types/dtos';
import { Link, useForm } from '@inertiajs/vue3';
import ReportNoteCard from './ReportNoteCard.vue';
import ReportNoteHead from './ReportNoteHead.vue';
import ReportNoteContent from './ReportNoteContent.vue';
import ReportNoteActionsCard from './ReportNoteActionsCard.vue';

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

const initialReports: Report[] = [
    { "id": 46, "average": "A", "content": "Maria es una estudiante amable y respetuosa que se integra activamente en el aula y demuestra una curiosidad innata por el aprendizaje. Con gran claridad, identifica los tres pasos principales del reciclaje y distingue con precisión entre materiales orgánicos e inorgánicos; además, reconoce los colores de los contenedores de reciclaje y su función, mostrando un progreso constante en esta área. Con entusiasmo, explora la importancia de reducir el consumo de recursos naturales y vincula eficazmente la acción de reciclar con sus beneficios ambientales. Asimismo, clasifica los desechos sólidos en los contenedores apropiados y contribuye activamente en la creación de objetos útiles a partir de material de desecho, exhibiendo un potencial prometedor en su participación, mientras maneja herramientas básicas de forma segura y eficiente. Demuestra un notable respeto por el medio ambiente al mantener su área limpia y desarrolla con compromiso sus habilidades para comunicar la importancia del proyecto de reciclaje. Asume con creciente responsabilidad el cuidado de los objetos creados y colabora de manera excelente con su equipo en las tareas asignadas, además de proponer ideas originales para la reducción del uso de plásticos o papel en el aula, destacando su creatividad e interés.", "suggestions": "", "studentName": "HURTADO MENDOZA HECTOR LUIS", "studentSurName": "", "learningProjectId": 4, "studentId": 35741 },
    { "id": 47, "average": "A", "content": "Maria es una estudiante amable y respetuosa, que siempre se muestra curiosa e interesada, participando activamente en todas las actividades. Ella identifica correctamente los tres pasos principales del ciclo de vida de los materiales y distingue con facilidad entre materiales orgánicos e inorgánicos. Además, profundiza su conocimiento sobre los colores de los contenedores de reciclaje y su función, y comienza a articular la relevancia de la reducción del consumo de recursos naturales, mientras relaciona la acción de reciclar con sus beneficios ambientales. En las actividades prácticas, organiza plenamente los desechos sólidos en los contenedores apropiados y muestra creciente entusiasmo en la elaboración de objetos útiles a partir de material de desecho, empleando herramientas básicas de forma segura y eficiente. Manifiesta respeto por el medio ambiente al mantener siempre limpia su área de trabajo y el entorno escolar, y está fortaleciendo su capacidad para comunicar la importancia del proyecto de reciclaje a sus compañeros y familiares. Asimismo, está desarrollando un sentido de compromiso en el cuidado de los objetos o espacios creados con material reutilizado, colabora activamente con su equipo en las tareas asignadas y formula ideas creativas para la reducción del uso de plásticos o papel en el aula.", "suggestions": "", "studentName": "HURTADO MENDOZA HECTOR LUIS", "studentSurName": "", "learningProjectId": 4, "studentId": 35741 }
];

// Estado reactivo (usando ref en lugar de useState de React)
const reports = ref<Report[]>(initialReports);
const modalOpen = ref(false);
const selectedReport = ref<Report | null>(null);




/**
 * 
 * @param reportId
 */
const handleDelete = (reportId: number): void => {
    reports.value = reports.value.filter(r => r.id !== reportId);
    console.log(`Boletín ${reportId} eliminado.`);
};

const closeModal = (): void => {
    modalOpen.value = false;
    selectedReport.value = null;
};

const impressForm = useForm({});

const impress = () => {
    impressForm.get('/test-docx')
}
</script>

<template>
    <ReportNoteCard>
        <ReportNoteHead :name="props.reportNote.studentName" :average="props.reportNote.average" />
        <ReportNoteContent :content="props.reportNote.content" />
        <ReportNoteActionsCard>
            <a :href="`/tickets/impress/${props.reportNote.id}`"
                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg text-sm">
                Descargar
            </a>
            <Link :href="`/tickets/show/${props.reportNote.id}`" :data="{ studentId: props.reportNote.studentId }"
                class="w-full sm:w-auto bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out text-sm">
            Editar
            </Link>
            <button @click="handleDelete(props.reportNote.id)"
                class="w-full sm:w-auto bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out text-sm">
                Eliminar
            </button>
        </ReportNoteActionsCard>
    </ReportNoteCard>

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
