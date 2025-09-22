<script setup lang="ts">
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import { useTeacherStore } from '@/store/TeacherStore';

const data = useTeacherStore();

const { form } = data;
</script>

<template>
    <section class="relative border border-emerald-200 grid gap-6 mb-6 md:grid-cols-2 rounded-lg p-3.5 pt-7">
        <h3 class="absolute -top-3.5 left-3 bg-background px-3 border border-emerald-200 rounded">Datos de personales
        </h3>
        <div>
            <Label for="name-id">
                <p>Nombre</p>
            </Label>
            <Input id="name-id" type="text" v-model="form.name" class="mt-2" placeholder="Doe" required />
        </div>
        <div>
            <Label for="surname-id">
                <p>Apellido</p>
            </Label>
            <Input id="surname-id" type="text" v-model="form.surname" class="mt-2" placeholder="Doe" required />
        </div>
        <div>
            <Label for="phone-id" class="flex flex-col items-start">
                <p class="block">Numero de Telefono</p>
                <span class="block text-[12px] text-gray-500">format: 4166526749</span>
            </Label>
            <Input id="phone-id" type="tel" pattern="[0-9]{10}" v-model="form.phone" placeholder="4166526749"
                class="mt-2" />
        </div>
    </section>
</template>
