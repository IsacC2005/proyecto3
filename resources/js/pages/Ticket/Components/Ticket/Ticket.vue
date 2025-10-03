<script setup lang="ts">
import { computed, ref } from 'vue';
import TicketCard from './TicketCard.vue';


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
    <TicketCard @click="isExpanded = !isExpanded">
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
    </TicketCard>
</template>