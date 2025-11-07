<script setup lang="ts">
import { onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import ContentPage from '@/components/ContentPage.vue';


const form = useForm({
    system_instruction: 'string',
    model: '',
    key: '',
    temperature: 0
})

interface ApiConfig {
    system_instruction: string;
    model: string;
    key: string;
    temperature: number;
}

const props = defineProps<{
    initialConfig: ApiConfig;
}>();

onMounted(() => {
    form.system_instruction = props.initialConfig.system_instruction;
    form.model = props.initialConfig.model;
    form.key = props.initialConfig.key;
    form.temperature = props.initialConfig.temperature;
})

const availableModels = ['gemini-2.5-flash-lite', 'gemini-2.5-flash', 'gemini-2.5-pro', 'gemini-2.5-nano'];

// Función para guardar y emitir el estado actual
const save = () => {
    form.post('/setting-ia');
};

</script>

<template>
    <AppLayout>
        <ContentPage>
            <h2 class="text-2xl font-bold text-indigo-700 mb-6 border-b pb-2">
                Configuración de la API de Gemini
            </h2>

            <form @submit.prevent="save" class="space-y-6">

                <div>
                    <label for="apiKey" class="block text-sm font-medium text-gray-700">Clave de API (Key)</label>
                    <input id="apiKey" v-model="form.key" type="password" maxlength="50" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border"
                        placeholder="Ingresa tu clave secreta de Gemini" />
                </div>

                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700">Modelo de IA</label>
                    <select id="model" v-model="form.model"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border bg-white">
                        <option v-for="modelName in availableModels" :key="modelName" :value="modelName">
                            {{ modelName }}
                        </option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:items-center">
                    <label for="temperature" class="text-sm font-medium text-gray-700 md:col-span-1">
                        Temperatura (Creatividad): <span class="font-semibold text-indigo-600">{{
                            form.temperature.toFixed(2) }}</span>
                    </label>
                    <input id="temperature" v-model.number="form.temperature" type="range" min="0.0" max="2.0"
                        step="0.01"
                        class="w-full md:col-span-2 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer range-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" />
                    <div class="md:col-span-3 text-xs text-gray-500 mt-[-10px]">
                        (0.0 = Deterministico, 1.0 = Máxima Creatividad)
                    </div>
                </div>

                <div>
                    <label for="systemInstruction" class="block text-sm font-medium text-gray-700">Instrucción del
                        Sistema
                        (`system_instruction`)</label>
                    <textarea id="systemInstruction" v-model="form.system_instruction" maxleng="1000" rows="5" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border"
                        placeholder="Define el tono y las reglas de la IA (e.g., tono positivo, sin repetición de verbos)." />
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full md:w-auto px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </ContentPage>
    </AppLayout>
</template>