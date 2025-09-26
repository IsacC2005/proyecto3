<script setup lang="ts">
import Label from '@/components/ui/label/Label.vue';
import Select from '@/components/ui/Select/Select.vue';
import { ref, watch } from 'vue';

const moment = [
    { id: null, name: 'Todos' },
    { id: 1, name: 'Momento I' },
    { id: 2, name: 'Momento II' },
    { id: 3, name: 'Momento III' }
]

const selectMoment = ref(null);

const emits = defineEmits(['moment']);

watch(selectMoment, () => {
    emits('moment', selectMoment.value);
});
</script>
<template>
    <Label class="relative w-50 m-2 p-2 pb-4 flex flex-col items-center border border-t-0 border-x-0 border-b-gray-400">
        <span class="absolute -bottom-1.5 left-0 px-1 bg-background text-[0.8rem] text-gray-400">Momento
            academico</span>
        <Select @select="selectMoment = $event" name="Todos" :options="moment" />
    </Label>
</template>