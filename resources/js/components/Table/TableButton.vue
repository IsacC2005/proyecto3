<template>
    <Link :href="route" :data="data" class="
      font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2
      transition-colors duration-200
    " :class="buttonClass">
    {{ name }}
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    route: {
        type: String,
        required: true
    },
    data: {
        type: Object,
        default: () => ({})
    },
    name: {
        type: String,
        required: true
    },
    color: {
        type: String,
        default: 'blue' // Color por defecto
    }
});

const buttonClass = computed(() => {
    const baseClasses = 'text-white';

    // Mapeo de colores a clases de Tailwind
    const colorMap: Record<string, string> = {
        blue: 'bg-blue-500 hover:bg-blue-600',
        green: 'bg-green-500 hover:bg-green-600',
        red: 'bg-red-500 hover:bg-red-600',
        gray: 'bg-gray-500 hover:bg-gray-600',
        // Puedes añadir más colores aquí
    };

    // Retorna las clases de color mapeadas o las por defecto
    const colorClasses = colorMap[props.color] || colorMap.blue;

    return `${baseClasses} ${colorClasses}`;
});
</script>
