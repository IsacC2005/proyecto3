<script setup lang="ts">
import { useManagerUsers } from '@/store/ManagerUsers';

const ManagerUsers = useManagerUsers();

const { formResetPassword, resetPassword } = ManagerUsers;

</script>

<template>
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold border-b pb-2 mb-4">Cambiar Contraseña</h2>

        <form @submit.prevent="resetPassword" class="space-y-4 max-w-lg">

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Nueva
                    Contraseña</label>
                <input id="password" v-model="formResetPassword.password" type="password" autocomplete="new-password"
                    min="8" max="254" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                    :class="{ 'border-red-500': formResetPassword.errors.password }" />
                <div v-if="formResetPassword.errors.password" class="text-red-500 text-sm mt-1">{{
                    formResetPassword.errors.password }}</div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                    Contraseña</label>
                <input id="password_confirmation" v-model="formResetPassword.password_confirmation" type="password"
                    min="8" max="254" autocomplete="new-password"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
            </div>

            <div class="pt-4 text-right">
                <button type="submit"
                    class="bg-gray-800 text-white py-2 px-4 rounded-md hover:bg-gray-900 disabled:opacity-50"
                    :disabled="formResetPassword.processing">
                    Establecer Contraseña
                </button>
            </div>
        </form>
    </div>
</template>