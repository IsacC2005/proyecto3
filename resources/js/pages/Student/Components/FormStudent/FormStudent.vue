<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { useStudentStore } from '@/store/StudentStore';

const data = useStudentStore();

const { form } = data;
</script>

<template>
    <form>
        <Label for="e_name">
            Nombre</Label>

        <Input type="text" id="e_name" class="mt-3 mb-4" v-model="form.name" placeholder="Ej. Jose Ramon" required />

        <Label for="e_surname">
            Apellido</Label>

        <Input type="text" id="e_surname" class="mt-3 mb-4" v-model="form.surname" placeholder="Ej. Camejo" required />

        <Label for="e_grade">
            Seleccione el grado academico del estudiante
        </Label>
        <select id="e_grade" class="mt-3" v-model="form.grade" required>
            <option value="0">Preescolar</option>
            <option value="1">Primer Grado</option>
            <option value="2">Segundo Grado</option>
            <option value="3">Tercer Grado</option>
            <option value="4">Cuarto Grado</option>
            <option value="5">Quinto Grado</option>
        </select>
        <slot />
    </form>
</template>