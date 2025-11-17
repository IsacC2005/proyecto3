<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import ContentPage from '@/components/ContentPage.vue';
import UserForm from './Partials/UserForm.vue';
import { useForm, router, Head } from '@inertiajs/vue3';
import PasswordReset from './Partials/PasswordReset.vue';
import { User, Role } from '@/types/dtos';
import { useManagerUsers } from '@/store/ManagerUsers';
import { onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { Pagination } from '@/types/dtos';
import UserActivities from './Partials/UserActivities.vue';
import { BreadcrumbItem } from '@/types';

type activityLog = {
    id: number
    description: string
    subject_type: string
    subject_id: number
    causer_name: number
    created_at: string
    properties: string
}

const ManagerUsers = useManagerUsers();

const { form } = ManagerUsers;


const { allRoles } = storeToRefs(ManagerUsers);

type UserBaseForm = Omit<User, 'password' | 'roles'>;

interface userForm extends UserBaseForm {
    roles: number[]
    [key: string]: any
}

const props = defineProps<{
    initialUser: userForm,
    roles: Role[],
    logs: Pagination<activityLog>
}>()

onMounted(() => {
    form.id = props.initialUser.id;
    form.name = props.initialUser.name;
    form.email = props.initialUser.email;
    form.roles = props.initialUser.roles;

    allRoles.value = props.roles;
})



const propso = {
    user: { id: 1, name: 'Usuario de Prueba', email: 'test@example.com' },
    roles: [
        { id: 1, name: 'Admin' },
        { id: 2, name: 'Editor' },
        { id: 3, name: 'Visitante' },
    ],
    userRoles: [
        { id: 1, name: 'Admin' },
    ],
    activities: [
        { id: 1, description: 'Inició sesión', created_at: new Date().toISOString() },
        { id: 2, description: 'Actualizó su perfil', created_at: new Date(Date.now() - 3600000).toISOString() }, // hace 1 hora
    ],
    errors: {},
};
// --------------------------------------------------------------------

// --- 1. Gestión de Datos Básicos y Roles ---
const userForm = useForm({
    name: props.initialUser.name,
    email: props.initialUser.email,
    // Mapeamos los roles a IDs para la sincronización
    roles: props.initialUser.roles
});

const updateUser = () => {
    userForm.put(route('admin.users.update', props.user.id), {
        preserveScroll: true,
        onSuccess: () => alert('✅ Usuario y roles actualizados correctamente.'),
        onError: () => alert('❌ Error al actualizar la información.'),
    });
};

const handleRoleChange = (roleId, event) => {
    const isChecked = event.target.checked;
    if (isChecked) {
        if (!userForm.roles.includes(roleId)) {
            userForm.roles.push(roleId);
        }
    } else {
        userForm.roles = userForm.roles.filter((id) => id !== roleId);
    }
};

// --- 2. Gestión de Contraseña ---
const passwordForm = useForm({
    password: '',
    password_confirmation: '',
});

const resetPassword = () => {
    passwordForm.post(route('admin.users.password.update', props.initialUser.id), {
        preserveScroll: true,
        onSuccess: () => {
            passwordForm.reset();
            alert('✅ Contraseña actualizada correctamente.');
        },
        onError: () => alert('❌ Error al cambiar la contraseña.'),
    });
};

// --- 3. Eliminación de Usuario ---
const deleteUser = () => {
    if (confirm('⚠️ ¿Estás seguro de que quieres eliminar este usuario?')) {
        router.delete(route('admin.users.destroy', props.initialUser.id), {
            preserveScroll: true,
            onSuccess: () => router.visit(route('admin.users.index')),
            onError: () => alert('❌ Error al eliminar el usuario.'),
        });
    }
};

// --- 4. Formato de Actividades ---
const formatActivityTime = (timestamp) => {
    const date = new Date(timestamp);
    return date.toLocaleTimeString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Gestión de Usuarios',
        href: '/user/index',
    },
    {
        title: 'Editar Usuario',
        href: `/manager/users/edit/${props.initialUser.id}`,
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Editar Usuario" />
        <Heading :title="`Editar Usuario ${props.initialUser.name}`" />
        <ContentPage>

            <h1 class="text-2xl font-bold mb-6">Editar Usuario: {{ props.initialUser.name }}</h1>
            <UserForm />

            <PasswordReset />



            <UserActivities :logs="props.logs" />

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold border-b pb-2 mb-4 text-red-600">Eliminar Usuario</h2>
                <p class="text-sm text-gray-600 mb-4">Esta acción es irreversible. El usuario y todos sus datos
                    serán
                    eliminados permanentemente.</p>

                <button @click="deleteUser"
                    class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 disabled:opacity-50">
                    Eliminar Usuario
                </button>
            </div>
        </ContentPage>
    </AppLayout>
</template>