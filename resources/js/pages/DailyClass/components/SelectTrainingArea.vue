<script setup lang="ts">
import { useReferenStore } from '@/store/ReferentStore';
import { storeToRefs } from 'pinia';

const data = useReferenStore();
const { ListTrainingArea } = storeToRefs(data);
</script>


<template>
    <div class="relative w-full font-sans my-4">
        <label for="training-area-select" class="block text-sm font-medium text-gray-700 mb-1">
            Área de Formación <span class="text-red-500">*</span>
        </label>

        <select id="training-area-select" v-model="data.form.trainingAreaId"
            class="w-full px-4 py-3 text-left border rounded-lg shadow-sm bg-white focus:outline-none focus:ring-1 appearance-none transition duration-150 ease-in-out"
            required>
            <option :value="null" disabled>Selecciona un Área de Formación...</option>

            <option v-for="option in ListTrainingArea" :key="option.id" :value="option.id">
                {{ option.title }}
            </option>
        </select>
    </div>
</template>