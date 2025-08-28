<template>
    <AppLayout>
        {{ props.project }}
        <div class="p-4 sm:p-6 md:p-8">
            <h1 class="text-3xl sm:text-4xl font-bold mb-4 text-gray-800">
                Detalles del Proyecto
            </h1>
            <h2 class="text-xl sm:text-2xl font-semibold text-indigo-600 mb-6">{{ props.project.title }}</h2>

            <div class="flex flex-col sm:flex-row items-center gap-4 mb-8">
                <button @click="createDailyClass"
                    class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                    Crear Nueva Clase Diaria
                </button>
                <button @click="editProject"
                    class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Modificar Proyecto
                </button>
            </div>

            <div class="space-y-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-3">Descripción General</h3>
                    <div v-html="props.project.content" class="text-gray-600 leading-relaxed prose max-w-none"></div>
                </div>

                <div v-for="dailyClass in props.project.daily_classes" :key="dailyClass.id"
                    class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-1">{{ dailyClass.title }}</h3>
                            <p class="text-sm text-gray-500">Fecha: {{ formatDate(dailyClass.date) }}</p>
                        </div>
                        <Link :href="`/daily-class/edit/${dailyClass.id}`">
                        Modificar
                        </Link>
                        <button @click="evaluateDailyClass(dailyClass.id)"
                            class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 transition-colors duration-200">
                            Evaluar
                        </button>
                    </div>

                    <div v-html="dailyClass.content" class="text-gray-600 mb-4 prose max-w-none"></div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    project: {
        type: Object,
        required: true,
        // Añadimos una validación básica para asegurarnos de que la estructura sea la esperada
        validator: (value: any) => {
            return value.hasOwnProperty('id') && value.hasOwnProperty('title') && value.hasOwnProperty('daily_classes');
        }
    }
});

// Formatea la fecha, reutilizando la misma función del componente anterior
const formatDate = (dateObject: any) => {
    if (!dateObject || !dateObject.date) return '';
    const date = new Date(dateObject.date);
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

// Métodos para los botones de acción
const createDailyClass = () => {
    // Lógica para navegar a la página de creación de clase
    console.log("Navegando a la página para crear una nueva clase...");
    // Ejemplo con Inertia: router.visit(route('daily-classes.create', { projectId: props.project.id }));
};

const editProject = () => {
    // Lógica para navegar a la página de modificación del proyecto
    console.log("Navegando a la página para modificar el proyecto...");
    // Ejemplo con Inertia: router.visit(route('projects.edit', { id: props.project.id }));
};

const evaluateDailyClass = (classId: number) => {
    // Lógica para navegar a la página de evaluación para la clase específica
    console.log(`Navegando a la página de evaluación para la clase con ID: ${classId}`);
    // Ejemplo con Inertia: router.visit(route('evaluations.show', { classId: classId }));
};
</script>
