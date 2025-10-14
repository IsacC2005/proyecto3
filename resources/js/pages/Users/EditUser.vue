<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, reactive, computed } from 'vue';
// En una aplicación real de Inertia/Vue, usarías:
// import { useForm } from '@inertiajs/vue3';
// import AppLayout from '@/layouts/AppLayout.vue'; // Asumiendo que existe

// Definición de Props (datos del usuario a editar)
const props = defineProps<{
    initialUser: {
        id: number;
        name: string;
        email: string;
        password: null | string; // Aunque es null en el JSON, en la DB es string
        role: string[];
        roleId: number;
        userable_id: number;
        userable: null;
    }
}>();

// --- SIMULACIÓN DEL useForm DE INERTIA.JS PARA VUE ---
// En un entorno real, solo usarías: const form = useForm({...})

interface FormData {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}

const initialFormData: FormData = {
    name: props.initialUser.name,
    email: props.initialUser.email,
    password: '',
    password_confirmation: '',
};

// Estado reactivo para los datos del formulario
const formData = reactive<FormData>({ ...initialFormData });
const errors = ref<Record<string, string | null>>({});
const processing = ref(false);


/**
 * Simula el envío de formulario con Inertia.
 */
const submitForm = async () => {
    processing.value = true;
    errors.value = {};

    // En una app real, usarías router.put(url, formData, options)
    const url = `/admin/users/${props.initialUser.id}`;

    try {
        console.log(`Simulando petición PUT a ${url} con datos:`, formData);

        // Simular respuesta exitosa después de un breve retraso
        await new Promise(resolve => setTimeout(resolve, 1500));

        // Simulación: Si se envía el email 'test@fail.com', mostramos error de validación
        if (formData.email === 'test@fail.com') {
            errors.value.email = 'El email ya está en uso. Intente con otro.';
            throw new Error("Simulated validation error");
        }

        console.log('Usuario actualizado con éxito!');
        // En Inertia, esto recargaría la página o mostraría un flash message

    } catch (error) {
        console.error("Error de simulación:", error);

        if (Object.keys(errors.value).length === 0) {
            errors.value.general = 'Hubo un error al procesar la solicitud. Inténtelo de nuevo.';
        }

    } finally {
        processing.value = false;
    }
};

/**
 * Maneja el cambio en los campos y limpia el error específico al escribir.
 */
const handleChange = (field: keyof FormData, event: Event) => {
    const value = (event.target as HTMLInputElement).value;
    formData[field] = value;

    // Limpiar error específico al escribir
    if (errors.value[field]) {
        errors.value[field] = null;
    }
};

// --- FIN DE SIMULACIÓN useForm ---
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50 flex items-start justify-center p-4 sm:p-6 lg:p-8">
            <div class="w-full max-w-lg bg-white p-8 rounded-xl shadow-2xl">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2 border-b pb-2">
                    Editar Usuario Administrativo
                </h1>
                <p class="text-sm text-gray-500 mb-6">
                    Editando: <span class="font-semibold text-indigo-600">{{ props.initialUser.name }}</span> (ID: {{
                        props.initialUser.id }})
                </p>

                <form @submit.prevent="submitForm">

                    <!-- Mensaje de Error General -->
                    <div v-if="errors.general"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ errors.general }}</span>
                    </div>

                    <!-- Campo Nombre/Usuario -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre/Usuario
                        </label>
                        <input id="name" type="text" v-model="formData.name" @input="handleChange('name', $event)"
                            :disabled="processing" :class="[
                                'w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150',
                                errors.name ? 'border-red-500' : 'border-gray-300'
                            ]" />
                        <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                    </div>

                    <!-- Campo Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input id="email" type="email" v-model="formData.email" @input="handleChange('email', $event)"
                            :disabled="processing" :class="[
                                'w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150',
                                errors.email ? 'border-red-500' : 'border-gray-300'
                            ]" />
                        <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                    </div>

                    <div class="mt-6 border-t pt-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Cambiar Contraseña</h2>

                        <!-- Campo Nueva Contraseña -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Nueva Contraseña (Dejar vacío para no cambiar)
                            </label>
                            <input id="password" type="password" v-model="formData.password"
                                @input="handleChange('password', $event)" :disabled="processing" :class="[
                                    'w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150',
                                    errors.password ? 'border-red-500' : 'border-gray-300'
                                ]" />
                            <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
                        </div>

                        <!-- Campo Confirmar Contraseña -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirmar Contraseña
                            </label>
                            <input id="password_confirmation" type="password" v-model="formData.password_confirmation"
                                @input="handleChange('password_confirmation', $event)" :disabled="processing" :class="[
                                    'w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150',
                                    errors.password_confirmation ? 'border-red-500' : 'border-gray-300'
                                ]" />
                            <p v-if="errors.password_confirmation" class="mt-1 text-sm text-red-600">{{
                                errors.password_confirmation }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" :disabled="processing" :class="[
                            'w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-lg font-medium text-white transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
                            processing
                                ? 'bg-indigo-400 cursor-not-allowed'
                                : 'bg-indigo-600 hover:bg-indigo-700'
                        ]">
                            <span v-if="processing" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Guardando...
                            </span>
                            <span v-else>
                                Guardar Cambios
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
