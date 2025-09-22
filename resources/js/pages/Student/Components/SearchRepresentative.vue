<script setup lang="ts">
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import ButtonSubmit from '@/components/ui/button/ButtonSubmit.vue';
import { Representative } from '@/types/dtos';
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps<{
    representative?: Representative
}>()

const form = useForm({
    idcard: 0
})

const search = () => {
    form.idcard = idcard.value
    form.get(route('student.create', {
        preserveScroll: true,
        preserveState: true
    }));
}

const idcard = ref(0);

const name = ref('');

onMounted(() => {
    if (props.representative) {
        idcard.value = props.representative.idcard;
        name.value = `${props.representative.name} ${props.representative.surname}`;
    }
})



</script>

<template>
    <div class="mb-5 p-4 pt-10 relative border border-emerald-200 rounded">
        <h3 class="absolute -top-4 left-8 px-2 py-0.5 bg-background shadow border border-emerald-200 rounded">
            <span v-if="!props.representative">Buscar representante</span>
            <span v-else>Datos del representante</span>
        </h3>
        <div v-if="!props.representative">
            <form @submit.prevent="search">
                <Label for="r_idcard_search">Escribe la cedula del representante para buscarlo</Label>
                <Input type="number" id="r_idcard_search" v-model="idcard" class="mt-2 mb-4"></Input>
                <ButtonSubmit text="Buscar" processing-text="Buscando..." :processing="form.processing" />
            </form>
        </div>
        <div v-else>
            <Label for="r_idcard_display">Cedula</Label>
            <Input id="r_idcard_display" type="text" class="mt-2 mb-4" v-model="idcard" readonly />
            <Label for="r_name">Nombre</Label>
            <Input id="r_name" type="text" class="mt-2 mb-4" v-model="name" readonly />
        </div>
    </div>
</template>