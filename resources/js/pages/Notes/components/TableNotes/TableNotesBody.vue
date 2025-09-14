<template>
    <tbody>
        <tr v-for="student in students" :key="student.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky-col-student">
                {{ student.name }}
            </td>
            <template v-for="referent in referents" :key="referent.id">
                <td v-for="indicator in referent.indicators" :key="indicator.id"
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ getNote(student.notesByReferent, referent.id, indicator.id) }}
                </td>
            </template>
        </tr>
    </tbody>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useAllNoteStore } from '@/store/AllNoteStore';

const store = useAllNoteStore();

const students = computed(() => store.notes);
const referents = computed(() => store.referents);

/**
 * Obtiene la nota de un estudiante para un referente teorico y un indicador específicos.
 * @param notesByReferent - Objeto con las notas agrupadas.
 * @param referentId - ID de la refente teorico.
 * @param indicatorId - ID del indicador.
 * @returns La nota correspondiente o '-' si no existe.
 */
function getNote(notesByReferent: any, referentId: number, indicatorId: number): string {
    return notesByReferent?.[referentId]?.[indicatorId] ?? '-';
}
</script>

<style scoped>
.sticky-col-student {
    position: sticky;
    left: 0;
    z-index: 10;
    background-color: #f9fafb;
    border-right: 1px solid #e5e7eb;
}
</style>