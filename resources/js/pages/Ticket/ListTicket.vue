<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import ReportNote from './Components/ReportNote/ReportNote.vue';
import { type ReportNote as ReportNoteType } from '@/types/dtos';

const props = defineProps<{
    ReportsNotes: ReportNoteType[]
}>()

const showDetails = (id: number) => {
    console.log(`mostrarndo todos los datos de ${id}`)
}
</script>

<template>
    <AppLayout>
        <Heading title="Boletas del proyecto de aprendizaje {{ proyecto de aprendizaje }}" />
        <div class="min-h-screen bg-background p-4 sm:p-8 font-sans">

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 max-w-6xl mx-auto">
                <template v-if="props.ReportsNotes.length > 0">
                    <ReportNote v-for="ReportNote in props.ReportsNotes" :key="ReportNote.id"
                        @showDetails="showDetails(ReportNote.id)" :reportNote="ReportNote" />

                </template>
                <div v-else class="md:col-span-2 lg:col-span-3 text-center p-10 bg-white rounded-xl shadow-lg">
                    <p class="text-xl text-gray-500">
                        No hay boletines disponibles.
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>