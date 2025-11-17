<script setup lang="ts">
import Paginator from '@/components/Paginator.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { defineProps } from 'vue';
import { Link, Head } from '@inertiajs/vue3';
import { Pagination, Role } from '@/types/dtos';
import { User } from '@/types/dtos';
import Heading from '@/components/Heading.vue';
import { BreadcrumbItem } from '@/types';

const props = defineProps<{
    users: Pagination<User>;
    roles: object
}>();

const formatRoles = (roles: string[]): string => {
    return roles.join(', ');
}

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Gestión de Usuarios',
        href: '/user/index',
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Gestión de Usuarios" />
        <Heading title="Gestión de Usuarios" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="p-6 lg:p-8 overflow-x-auto">

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Lista de Usuarios del Sistema</h3>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Roles
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in props.users.data" :key="user.id" class="hover:bg-gray-50">

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ user.id }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ user.name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ user.email }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800"
                                            v-for="role in user.roles" :key="role">
                                            {{ props.roles[role] }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="`/manager/users/edit/${user.id}`"
                                            class="text-blue-600 hover:text-blue-900">Editar</Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <Paginator :pages="props.users.links" />
            </div>
        </div>
    </AppLayout>
</template>