<template>
    <div class="mx-2 sm:mx-10 grid grid-cols-1 md:grid-cols-3 gap-6">

        <ProjectOptionCard :title="projectStates.m1.title"
            description="Crea un proyecto basado en el diseño curricular obligatorio. Ideal para la planificación anual.">
            <div v-if="projectStates.m1.exists">
                <Link
                    class="w-full py-2 px-4 rounded transition duration-150 bg-blue-600 hover:bg-blue-700 text-blue-100 font-bold shadow-md"
                    :href="`/learning-project/show/${projectStates.m1.project?.id}`">Ver Detalles</Link>
            </div>
            <div v-else>
                <button @click="handleCreate(1)"
                    class="w-full py-2 rounded transition duration-150 bg-emerald-500 hover:bg-emerald-700 text-blue-100 font-bold shadow-md">
                    Crear Proyecto
                </button>
            </div>
        </ProjectOptionCard>

        <ProjectOptionCard :title="projectStates.m2.title"
            description="Crea un proyecto interdisciplinario que una varias áreas de conocimiento.">
            <div v-if="projectStates.m2.exists">
                <Link
                    class="w-full py-2 px-4 rounded transition duration-150 bg-blue-600 hover:bg-blue-700 text-blue-100 font-bold shadow-md"
                    :href="`/learning-project/show/${projectStates.m2.project?.id}`">Ver Detalles</Link>
            </div>
            <div v-else>
                <button @click="handleCreate(2)"
                    class="w-full py-2 rounded transition duration-150 bg-emerald-500 hover:bg-emerald-700 text-emerald-950 font-bold shadow-md">
                    Crear Proyecto
                </button>
            </div>
        </ProjectOptionCard>

        <ProjectOptionCard :title="projectStates.m3.title"
            description="Diseña un proyecto enfocado en habilidades específicas o refuerzo de contenidos.">
            <div v-if="projectStates.m3.exists">
                <Link
                    class="w-full py-2 px-4 rounded transition duration-150 bg-blue-600 hover:bg-blue-700 text-white shadow-md"
                    :href="`/learning-project/show/${projectStates.m3.project?.id}`">Ver Detalles</Link>
            </div>
            <div v-else>
                <button @click="handleCreate(3)"
                    class="w-full py-2 rounded transition duration-150 bg-emerald-500 hover:bg-emerald-700 text-emerald-950 font-bold shadow-md">
                    Crear Proyecto
                </button>
            </div>
        </ProjectOptionCard>
    </div>
</template>

<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import ProjectOptionCard from './ProjectOptionCard.vue';
import { defineEmits, defineProps, computed } from 'vue'; // Usamos 'computed' en lugar de ref/onMounted
import { LearningProject } from '@/types/dtos';
import { Link } from '@inertiajs/vue3';

// --- DEFINICIÓN DE PROPS ---
const props = defineProps<{
    projects: LearningProject[]
}>()

// --- PROPIEDAD COMPUTADA PARA CLASIFICAR PROYECTOS ---
// Esta propiedad procesa la lista una sola vez y se actualiza reactivamente.
const projectStates = computed(() => {
    // Encuentra el proyecto para cada momento o usa null si no existe.
    const m1 = props.projects.find(p => p.schoolMoment === 1);
    const m2 = props.projects.find(p => p.schoolMoment === 2);
    const m3 = props.projects.find(p => p.schoolMoment === 3);

    const formatState = (project: LearningProject | undefined, moment: number) => {
        const exists = !!project;
        return {
            exists: exists,
            project: project,
            title: `Momento ${moment}${exists ? ` - ${project!.title.substring(0, 30)}...` : ''}`,
        };
    };

    return {
        m1: formatState(m1, 1),
        m2: formatState(m2, 2),
        m3: formatState(m3, 3),
    };
});

// --- MANEJO DE EVENTOS ---
const emit = defineEmits(['selectType']);

/**
 * Emite el tipo de proyecto seleccionado (1, 2, o 3) para que el padre pueda mostrar el formulario.
 * @param projectType El Momento Escolar ID a crear.
 */
const handleCreate = (projectType: number) => {
    // Solo emitimos si el proyecto NO existe (para forzar la creación)
    if (!projectStates.value[`m${projectType}`].exists) {
        emit('selectType', projectType);
    }
    // Si el proyecto existe, la acción se manejará con el Link de Inertia.
};
</script>