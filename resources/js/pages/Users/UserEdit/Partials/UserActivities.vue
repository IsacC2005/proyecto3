<script setup lang="ts">
import { computed } from 'vue';
import { Pagination } from '@/types/dtos';
import Paginator from '@/components/Paginator.vue';

type activityLog = {
    id: number
    description: string
    subject_type: string
    subject_id: number
    causer_name: number
    created_at: string
    properties: string
}

const props = defineProps<{ logs: Pagination<activityLog> }>()

const formatChanges = (properties: string) => {
    if (!properties || !properties.old || !properties.attributes) {
        return 'No hay cambios detallados.';
    }

    let output = '';
    const oldKeys = Object.keys(properties.old);

    oldKeys.forEach(key => {
        const oldValue = properties.old[key];
        const newValue = properties.attributes[key];

        if (oldValue !== newValue) {
            output += `| ${key}: '${oldValue}' a '${newValue}' `;
        }
    });

    return output.trim() || 'Cambios no especificados.';
};
</script>

<template>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            Registro de Actividades
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Modelo Afectado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Detalle de Cambios</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="log in props.logs.data" :key="log.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ log.description
                        }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ log.causer_name
                        }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{
                            log.subject_type ?
                                log.subject_type.split('\\').pop() : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{
                            log.subject_id ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <span v-if="log.properties && (log.properties.old || log.properties.attributes)">
                                {{ formatChanges(log.properties) }}
                            </span>
                            <span v-else>
                                —
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ log.created_at
                        }}</td>
                    </tr>
                    <tr v-if="logs.data.length === 0">
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No hay
                            registros de
                            actividad.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <Paginator :pages="logs.links" />
        </div>
    </div>
</template>