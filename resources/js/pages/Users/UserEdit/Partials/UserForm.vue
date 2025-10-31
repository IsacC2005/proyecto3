<script setup lang="ts">
import { useManagerUsers } from '@/store/ManagerUsers';
import { Role } from '@/types/dtos';
import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';

const ManagerUsers = useManagerUsers();

const { form, UpdateUser } = ManagerUsers;

const { allRoles } = storeToRefs(ManagerUsers);



const handleRoleChange = (roleId: number, event) => {
    const isChecked = event.target.checked;
    if (isChecked) {
        if (!contentRole(roleId)) {
            form.roles.push(roleId);
        }
    } else {
        form.roles = form.roles.filter((id) => id !== roleId);
    }
};

const contentRole = (roleId: number): boolean => {
    return form.roles.includes(roleId);
}

</script>

<template>
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold border-b pb-2 mb-4">Información del Usuario y Roles</h2>

        <form @submit.prevent="UpdateUser" class="space-y-4">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input id="name" type="text" max="100" v-model="form.name"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                    :class="{ 'border-red-500': form.errors.name }" />
                <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                    {{ form.errors.name }}
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" max="250" v-model="form.email"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                    :class="{ 'border-red-500': form.errors.email }" />
                <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                    {{ form.errors.email }}
                </div>
            </div>
            <div class="pt-4">
                <span class="block text-sm font-medium text-gray-700 mb-2">Roles</span>
                <div class="flex flex-wrap gap-4">
                    <div v-for="role in allRoles" :key="role.id" class="flex items-center">
                        <input :id="`role-${role.id}`" type="checkbox" :checked="contentRole(role.id)"
                            @change="($event) => handleRoleChange(role.id, $event)"
                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                        <label :for="`role-${role.id}`" class="ml-2 text-sm text-gray-700">{{ role.name
                            }}</label>
                    </div>
                </div>
                <div v-if="form.errors.roles" class="text-red-500 text-sm mt-1">
                    {{ form.errors.roles }}
                </div>
            </div>

            <div class="pt-4 text-right">
                <button type="submit"
                    class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 disabled:opacity-50"
                    :disabled="false">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</template>