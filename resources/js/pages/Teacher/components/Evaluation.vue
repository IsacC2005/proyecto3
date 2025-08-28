<template>

    <!-- El componente de clase diaria con los nuevos estilos -->
    <li class="list-none">
        <Link :href="`/teacher/evaluate/class`" :data="{ class_id: props.id }" class="
                flex items-center justify-center p-4 rounded-xl
                text-white font-semibold text-lg text-center
                shadow-lg transition-all duration-300 transform
                bg-gradient-to-r from-blue-600 to-blue-800
                hover:scale-105 hover:shadow-2xl hover:from-blue-700 hover:to-blue-900
                dark:from-blue-700 dark:to-blue-900 dark:hover:from-blue-800 dark:hover:to-blue-950
                w-full
            " aria-current="page">
        <!-- SVG de un icono de libro, reemplazando el icono de usuario -->
        <svg class="w-5 h-5 me-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.468 9.231 5.068 7.5 5.253c-2.936.577-4.936 2.684-4.936 5.869 0 3.185 2 5.292 4.936 5.869C9.231 18.932 10.832 19.332 12 18.747m0-13C13.168 5.468 14.769 5.068 16.5 5.253c2.936.577 4.936 2.684 4.936 5.869 0 3.185-2 5.292-4.936 5.869C14.769 18.932 13.168 18.932 12 18.747m0-13V6.253" />
        </svg>
        {{ props.name }}
        </Link>
    </li>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    id: {
        type: Number,
        required: true,
        default: 0
    },
    name: {
        type: String,
        required: true,
        default: ''
    },
    // Nota: La prop 'link' no es necesaria en este componente ya que Inertia usa la prop 'data' para pasar información.
    // La ruta se construye con un template string.
});

// Datos de ejemplo para el contenedor
const classes = [
    { id: 1, name: 'Clase de Matemáticas' },
    { id: 2, name: 'Clase de Ciencias' },
    { id: 3, name: 'Clase de Historia' },
    { id: 4, name: 'Clase de Arte' },
];
</script>
