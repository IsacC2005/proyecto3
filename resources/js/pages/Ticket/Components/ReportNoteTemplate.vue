<script setup lang="ts">
import { type ReportNote } from '@/types/dtos';

// Definición de tipos simplificada basada en tu imagen
interface BoletinData {
    docente: string;
    gradoSeccion: string;
    estudiante: string;
    docIdentidad: string;
    anoEscolar: string;
    lapso: string;
    proyecto: string;
    asistencias: number;
    inasistencia: number;
    literal: string;
    descripcionLogros: string;
    sugerencias: string;
}

const props = defineProps<{
    data: ReportNote;
}>();
</script>

<template>
    <div class="boletin-container">
        <header class="boletin-header">
            <div class="header-logo">
                <span class="text-xs font-bold">Gobierno Bolivariano de Venezuela</span>
            </div>
            <div class="header-title">
                Ministerio del Poder Popular <br>
                para la Educación
            </div>
            <div class="header-center">
                Centro de Desarrollo de la Calidad <br>
                Educativa Guárico
            </div>
        </header>

        <div class="school-info">
            <strong>ESCUELA BÁSICA JOSE RAMÓN CAMEJO</strong><br>
            CÓDIGO DE PLANTEL: ODD04651209<br>
            ALTAGRACIA DE ORITUCO
        </div>

        <h1 class="boletin-title">
            BOLETÍN INFORMATIVO DE LOS APRENDIZAJES
        </h1>

        <table class="data-table">
            <tr>
                <td class="label">Docente:</td>
                <td class="value">{{ data.docente }}</td>
                <td class="label">Grado y sección:</td>
                <td class="value">{{ data.gradoSeccion }}</td>
            </tr>
            <tr>
                <td class="label">Estudiante:</td>
                <td class="value">{{ data.estudiante }}</td>
                <td class="label">Doc. Identidad:</td>
                <td class="value">{{ data.docIdentidad }}</td>
            </tr>
            <tr>
                <td class="label">Año Escolar:</td>
                <td class="value">{{ data.anoEscolar }}</td>
                <td class="label">Lapso:</td>
                <td class="value">{{ data.lapso }}</td>
            </tr>
            <tr>
                <td class="label">Proyecto:</td>
                <td class="value" colspan="3">{{ data.proyecto }}</td>
            </tr>
            <tr>
                <td class="label">Asistencias:</td>
                <td class="value">{{ data.asistencias }}</td>
                <td class="label">Inasistencia:</td>
                <td class="value">{{ data.inasistencia }}</td>
                <td class="literal-label">Literal:</td>
                <td class="literal-value">{{ data.literal }}</td>
            </tr>
        </table>

        <div class="section-title">
            DESCRIPCIÓN DE LOS LOGROS, AVANCES Y ALCANCES EN EL DESARROLLO DEL APRENDIZAJE EN LAS ÁREAS ACADÉMICAS
        </div>
        <div class="section-content logros">
            <p v-html="data.descripcionLogros"></p>
        </div>

        <div class="section-title sugerencias-title">
            SUGERENCIAS
        </div>
        <div class="section-content sugerencias">
            <p>{{ data.sugerencias }}</p>
        </div>

        <footer class="boletin-footer">
            <div class="firma-box">
                <span class="cargo">MSc. María Ledezma</span>
                <span class="cargo">Directora (e)</span>
                <div class="firma-line"></div>
                <span class="text-sm">Firma y Sello</span>
            </div>

            <div class="firma-box">
                <span class="cargo">Representante</span>
                <div class="firma-line"></div>
                <span class="text-sm">Firma y Sello</span>
            </div>

            <div class="firma-box">
                <span class="cargo">{{ data.docente }}</span>
                <span class="cargo">Docente de Aula</span>
                <div class="firma-line"></div>
                <span class="text-sm">Firma y Sello</span>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.boletin-container {
    width: 210mm;
    min-height: 297mm;
    font-family: Arial, sans-serif;
    font-size: 10pt;
    background-color: white;
}

.boletin-header {
    display: grid;
    grid-template-columns: 1fr 2fr 2fr 1fr;
    align-items: center;
    text-align: center;
    margin-bottom: 10px;
}

.header-title,
.header-center {
    font-size: 8pt;
    font-weight: bold;
}

.school-info {
    text-align: center;
    font-size: 9pt;
    margin-bottom: 15px;
}

.boletin-title {
    text-align: center;
    font-size: 11pt;
    font-weight: 900;
    border: 1px solid black;
    padding: 5px;
    margin-bottom: 15px;
    background-color: #f0f0f0;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

.data-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.data-table td {
    border: 1px solid black;
    padding: 4px 8px;
    vertical-align: top;
    font-size: 9pt;
}

.data-table .label {
    width: 12%;
    font-weight: bold;
    background-color: #e0e0e0;
}

.data-table .value {
    width: 38%;
}

.data-table .literal-label {
    width: 5%;
    font-weight: bold;
    background-color: #e0e0e0;
}

.data-table .literal-value {
    width: 5%;
    text-align: center;
    font-weight: bold;
    font-size: 11pt;
}

.section-title {
    font-weight: bold;
    text-align: center;
    border: 1px solid black;
    padding: 3px;
    margin-top: 10px;
    background-color: #e0e0e0;
}

.section-content {
    border: 1px solid black;
    border-top: none;
    padding: 10px;
    min-height: 50px;
    /* Espacio mínimo */
    line-height: 1.4;
    text-align: justify;
}

.sugerencias-title {
    margin-top: 20px;
}

.boletin-footer {
    display: flex;
    justify-content: space-around;
    align-items: flex-end;
    margin-top: 40px;
    text-align: center;
}

.firma-box {
    width: 30%;
    display: flex;
    flex-direction: column;
}

.firma-line {
    border-top: 1px solid black;
    margin: 30px 0 5px 0;
}

.cargo {
    font-size: 9pt;
    font-weight: bold;
}
</style>