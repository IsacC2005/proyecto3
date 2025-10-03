<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import printJS from 'print-js';
// 1. Importa el nuevo componente
import Ticket from './Components/Ticket/Ticket.vue';
import BoletinTemplate from './Components/BoletinTemplate.vue';

const props = defineProps({
    // El tipo debe ser Array de objetos, coincidiendo con el JSON
    tickets: {
        type: Array as () => Array<any>, // Usamos any si no tienes un tipo definido globalmente
        required: true
    }
})

const boletinData = {
    docente: "YURAIMA PEREZ",
    gradoSeccion: "3 B",
    estudiante: "SANCHEZ CAMPOS ABEL ISAI",
    docIdentidad: "11617081892",
    anoEscolar: "2024-2025",
    lapso: "TERCERO",
    proyecto: "Nombre del Proyecto de Aprendizaje",
    asistencias: 37,
    inasistencia: 13,
    literal: "C",
    descripcionLogros: "Es un estudiante participativo, amistoso y educado. Lee fluido de forma comprensiva, escribe legible y con pulcritud, clasifica las palabras según el número de sílabas, realiza cuento utilizando recursos literarios. Resuelve ejercicios de adición, sustracción con números naturales y decimales, representa gráficamente fracciones. Dibuja las etapas de reproducción de las plantas, clasifica materiales naturales y artificiales, elabora proyecto de vida. Realiza dibujos de los símbolos patrios, socializa árbol genealógico con seguridad utilizando el recurso apropiadamente, elabora producción plástica de las efemérides. Escenifica personajes imaginarios. Participa en carreras de relevo, desarrolla con coherencia las actividades de velocidad.",
    sugerencias: "Te animo a que practiques la tabla de multiplicar, operaciones básicas matemáticas de multiplicación y división con números naturales y decimales.",
};

const printBoletin = () => {
    // 1. Obtener el ID o la referencia del elemento que contiene el Boletín.
    // Usaremos el ID del contenedor que envuelve BoletinTemplate.
    const elementId = 'boletin-print-target';

    // 2. Ejecutar printJS
    printJS({
        printable: elementId, // ID del elemento HTML que quieres imprimir
        type: 'html',        // Indicamos que el contenido es HTML
        targetStyles: ['*'], // Copia todos los estilos aplicados al elemento y sus hijos
        header: null,        // No queremos encabezado extra
        documentTitle: `Boletin_${boletinData.estudiante.replace(/\s/g, '_')}`, // Título del archivo PDF
    });
};
</script>

<template>
    <AppLayout>
        <h1>
            Lista de boletas ({{ props.tickets.length }})
        </h1>
        <div class="print-controls">
            <button @click="printBoletin" class="print-button">
                Imprimir/Guardar como PDF (via print-js)
            </button>
        </div>
        <div id="boletin-print-target" ref="printContent">
            <BoletinTemplate :data="boletinData" />
        </div>

        <div class="boletas-container">
            <Ticket v-for="boleta in props.tickets" :key="boleta.id" :boleta="boleta" />
        </div>
    </AppLayout>
</template>

<style scoped>
.boletas-container {
    /* Puedes usar Flexbox o Grid para mejorar la disposición si quieres varias columnas */
    display: flex;
    flex-direction: column;
    gap: 10px;
    /* Espacio entre cada tarjeta */
    max-width: 800px;
    /* Limita el ancho del contenedor */
    margin: 0 auto;
    /* Centra el contenedor si lo deseas */
    padding-top: 20px;
}
</style>