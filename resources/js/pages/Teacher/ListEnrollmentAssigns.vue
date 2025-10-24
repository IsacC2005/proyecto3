<template>
    <AppLayout>
        <template v-if="props.enrollments.length > 0">
            <Heading :title="`Secciones asignadas`" />
            <div class="p-2 sm:p-4 md:p-6">
                <GridSectionsAssing :sections="props.enrollments" />
            </div>
        </template>
        <template v-else>
            <Heading :title="`Aun no tienes una seccion asignada`"
                :description="`Debes esperar a que el administrador te asigne una sección`" />
        </template>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import { Section } from '@/types/dtos';
import Heading from '@/components/Heading.vue';
import GridSectionsAssing from './components/GridSectionsAssing.vue';

const props = defineProps<{
    enrollments: Section[]
}>()
</script>
