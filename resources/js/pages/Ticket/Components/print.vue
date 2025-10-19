<script setup lang="ts">
import { ref } from 'vue';
import printJS from 'print-js'; // 👈 Importamos la librería
import BoletinTemplate from './ReportNoteTemplate.vue';

const props = defineProps({
    boletinData: {
        type: Object,
        required: true
    }
});

// Referencia al contenedor que queremos imprimir
const printContent = ref(null);

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
        documentTitle: `Boletin_${props.boletinData.estudiante.replace(/\s/g, '_')}`, // Título del archivo PDF

        // Esta es la parte crucial: la librería AÍSLA este elemento del resto de la página
        // en un <iframe> invisible antes de llamar a window.print().
    });
};
</script>

<template>
    <div class="print-controls">
        <button @click="printBoletin" class="print-button">
            Imprimir/Guardar como PDF (via print-js)
        </button>
    </div>

    <div id="boletin-print-target" ref="printContent">
        <BoletinTemplate :data="props.boletinData" />
    </div>
</template>

<style scoped>
/* Las media queries CSS siguen siendo útiles, pero print-js maneja el aislamiento.
   Aquí solo necesitarías las reglas para el botón de impresión. */
.print-controls {
    /* ... estilos ... */
}

@media print {

    /* Ocultamos los controles, pero printJS ya hizo el aislamiento del contenido. */
    .print-controls {
        display: none !important;
    }
}
</style>