<template>
    <h3 class="text-lg font-bold text-gray-700 mb-4">Indicadores de Evaluación asfsdf</h3>

    <div v-for="(indicator, index) in data.form.indicators" :key="index" class="flex items-center gap-4 mb-4">
        <input type="text" v-model="indicator.title" placeholder="Ej: Resuelve problemas con código"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            required>
        <button type="button" @click="removeIndicator(index)"
            class="text-red-500 hover:text-red-700 transition-colors duration-200" aria-label="Eliminar indicador">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </div>
    <button @click="addIndicator('')"
        class="flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                clip-rule="evenodd" />
        </svg>
        Añadir Indicador
    </button>
</template>

<script setup lang="ts">
import { useReferenStore } from '@/store/ReferentStore';

const data = useReferenStore();

const { removeIndicator, addIndicator } = data;
</script>