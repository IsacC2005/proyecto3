<script setup lang="ts">

const props = defineProps({
    lastUpdate: {
        type: String,
        required: true
    }
})

const formatLastUpdate = (dateString: string) => {
    if (!dateString) return 'Nunca';
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
    } catch {
        return dateString; // Fallback
    }
}
</script>

<template>
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <label class="block text-sm font-medium text-gray-500 mb-1">
            Última Sincronización Exitosa:
        </label>
        <p class="text-lg font-semibold text-indigo-700">
            {{ formatLastUpdate(props.lastUpdate) }}
        </p>
    </div>
</template>