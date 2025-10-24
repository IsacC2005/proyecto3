<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { useUserStore } from '@/store/UserStore';
import { storeToRefs } from 'pinia';

const data = useUserStore();

const { form, repeatPassword } = storeToRefs(data);
</script>


<template>
    <section class="relative border border-emerald-200 rounded-lg p-3.5 pt-7">
        <h3 class="absolute -top-3.5 left-3 bg-background px-3 border border-emerald-200 rounded">Datos de acceso</h3>
        <div class="mb-6">
            <Label for="email" class="block mb-2 text-sm font-medium text-foreground">
                Correo Electronico
            </Label>
            <Input type="email" id="email" v-model="form.email" placeholder="john.doe@company.com" required />
        </div>
        <div class="mb-6">
            <Label for="password" class="block mb-2 text-sm font-medium text-foreground">Contraseña</Label>
            <Input type="password" id="password" v-model="form.password" placeholder="•••••••••" required />
        </div>
        <div class="mb-6">
            <Label for="confirm_password" class="block mb-2 text-sm font-medium text-foreground">Confirmar
                Contraseña</Label>
            <Input type="password" id="confirm_password" v-model="repeatPassword" placeholder="•••••••••" required />
        </div>
    </section>
</template>