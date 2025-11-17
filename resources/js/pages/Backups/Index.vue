<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import Heading from '@/components/Heading.vue';

const props = defineProps({
    backupListOutput: String,
    success: String,
    error: String,
});

const backupForm = useForm({});

const runBackup = () => {
    backupForm.post(route('backups.store'), {
        preserveScroll: true
    });
};

// Formulario para limpiar respaldos
const cleanForm = useForm({});

const cleanBackups = () => {
    if (confirm('¿Estás seguro de que quieres ejecutar la limpieza de respaldos? Se borrarán los archivos antiguos según la política de retención.')) {
        cleanForm.delete(route('backups.destroy'), {
            preserveScroll: true
        });
    }
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Gestión de Respaldos',
        href: '/backups',
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Heading title="Gestión de Respaldos de Base de Datos" />
        <div class="container mx-auto p-4">
            <div v-if="success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ success }}</p>
            </div>
            <div v-if="error" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p>{{ error }}</p>
            </div>

            <div class="flex space-x-4 mb-6">
                <button @click="runBackup" :disabled="backupForm.processing"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50">
                    <span v-if="backupForm.processing">Creando Respaldo...</span>
                    <span v-else>💾 Ejecutar Nuevo Respaldo</span>
                </button>

                <button @click="cleanBackups" :disabled="cleanForm.processing"
                    class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 disabled:opacity-50">
                    <span v-if="cleanForm.processing">Limpiando...</span>
                    <span v-else>🧹 Limpiar Respaldos Antiguos</span>
                </button>
            </div>

            <h2 class="text-2xl font-semibold mt-8 mb-4">Listado de Respaldos</h2>
            <div class="bg-gray-800 text-green-400 p-4 rounded-md shadow-lg overflow-x-auto">
                <pre>{{ props.backupListOutput }}</pre>
            </div>
        </div>
    </AppLayout>
</template>