<template>
    <div class="editor-container">
        <QuillEditor theme="snow" v-model:content="editorContent"
            :options="isMobile ? editorOptionsMobile : editorOptions" contentType="html"
            @update:content="handleUpdate" />
    </div>
</template>

<script setup lang="ts">
import { ref, watch, defineProps, defineEmits, onMounted, computed } from 'vue';
import { QuillEditor } from '@vueup/vue-quill';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    }
});

const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth <= 640;
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

const emit = defineEmits(['update:modelValue']);

const editorContent = ref(props.modelValue);

const editorOptions = {
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': [] }],
            ['link'],
            ['clean']
        ],
    },
    placeholder: 'Escribe tu contenido aquí...'
};

const editorOptionsMobile = {
    modules: {
        toolbar: [
            [{ 'font': [] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'align': [] }],
            [{ 'align': [] }],
        ],
    },
    placeholder: 'Escribe tu contenido aquí...'
};

const handleUpdate = () => {
    emit('update:modelValue', editorContent.value);
};
</script>

<style scoped>
.editor-container {
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
}

:deep(.ql-container) {
    min-height: 200px;
    max-height: 500px;
    overflow-y: auto;
    font-size: 16px;
}

:deep(.ql-toolbar) {
    border-bottom: 1px solid #ccc;
}
</style>
