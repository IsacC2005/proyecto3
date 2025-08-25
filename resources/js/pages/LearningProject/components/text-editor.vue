<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css'; // Estilos
import { Head } from '@inertiajs/vue3';
import { DefineProps } from 'vue';

const content = ref('');

const props = defineProps({
    onContent: Function,
});

onMounted(() => {
    sendContent();
});

const sendContent = () => {
    props.onContent(content);
}
</script>

<template>

    <Head title="Editor de Texto" />

    <h1 class="text-2xl font-bold mb-4">Contenido del Proyecto de Aprendizaje</h1>
    <QuillEditor theme="snow" v-model:content="content" contentType="html" toolbar="full" />

    <div class="mt-4 p-4 border rounded bg-gray-100">
        <h2 class="font-semibold">Contenido guardado:</h2>
        <div v-html="content" class="prose max-w-none"></div>
    </div>
</template>

<style>
/* Estilos opcionales para el div de previsualización */
.prose img {
    max-width: 100%;
    height: auto;
}
</style>
