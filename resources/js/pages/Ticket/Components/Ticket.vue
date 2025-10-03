<script setup lang="ts">
import { ref, computed } from 'vue';

const props = defineProps({
    // Definimos el tipo de la boleta (ajusta si tienes una interfaz/modelo más formal)
    boleta: {
        type: Object as () => {
            id: number;
            average: string;
            content: string;
            suggestions: string;
            learningProjectId: number;
            studentId: number;
        },
        required: true
    }
});

// Estado para controlar si la tarjeta está expandida o no
const isExpanded = ref(false);

// Título compacto (usaremos el ID y el promedio para la tarjeta pequeña)
const compactTitle = computed(() => {
    return `Boleta #${props.boleta.id} | Promedio: ${props.boleta.average}`;
});

// Resumen del contenido para la vista compacta
const compactSummary = computed(() => {
    // Tomamos los primeros 80 caracteres del contenido y añadimos puntos suspensivos
    const maxLength = 80;
    if (props.boleta.content.length <= maxLength) {
        return props.boleta.content;
    }
    return props.boleta.content.substring(0, maxLength) + '...';
});
</script>

<template>
    <div class="boleta-card" @click="isExpanded = !isExpanded">
        <div class="card-header">
            <span class="card-title">{{ compactTitle }}</span>
            <span class="expand-icon">{{ isExpanded ? '▲' : '▼' }}</span>
        </div>

        <div v-if="!isExpanded" class="card-body-compact">
            {{ compactSummary }}
        </div>

        <div v-if="isExpanded" class="card-body-full">
            <p><strong>Contenido Completo:</strong> {{ props.boleta.content }}</p>
            <p v-if="props.boleta.suggestions">
                <strong>Sugerencias:</strong> {{ props.boleta.suggestions }}
            </p>
        </div>
    </div>
</template>

<style scoped>
.boleta-card {
    border: 1px solid #e2e8f0;
    /* Color de borde claro */
    border-radius: 8px;
    /* Bordes redondeados */
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    /* Sombra suave */
    cursor: pointer;
    /* Indica que es clickeable */
    transition: all 0.2s ease-in-out;
    background-color: #ffffff;
    /* Fondo blanco */
}

.boleta-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    /* Sombra al pasar el ratón */
    transform: translateY(-2px);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: bold;
    margin-bottom: 5px;
    color: #34495e;
    /* Color de texto principal */
}

.card-title {
    font-size: 1.1em;
}

.expand-icon {
    font-size: 0.8em;
    color: #42b983;
    /* Un color de acento */
}

.card-body-compact {
    font-size: 0.9em;
    color: #606f7b;
    /* Texto secundario */
}

.card-body-full {
    margin-top: 10px;
    border-top: 1px dashed #e2e8f0;
    padding-top: 10px;
    font-size: 0.9em;
    color: #4a5568;
}
</style>