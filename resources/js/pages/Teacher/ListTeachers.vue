<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 bg-background rounded-lg shadow-md relative">
            <h1 class="text-2xl font-bold mb-4 text-primary dark:text-primary">Lista de Profesores</h1>


            <DataTable :items="teachers.data" :headers="headers">
                <template #body="{ item }">
                    <td v-if="!isMobile" class="py-4 px-6 text-primary text-sm">{{ item.id }}</td>
                    <td class="py-4 px-6 text-primary">{{ item.name }}</td>
                    <td class="py-4 px-6 text-primary">{{ item.surname }}</td>
                    <td v-if="!isMobile" class="py-4 px-6 text-primary text-sm">{{ item.phone }}</td>
                    <td :key="item.id" class="py-4 px-6 text-primary">
                        <Link href="/teacher/edit" :data="{ teacher_id: item.id }" class="
                            text-foreground
                            border border-muted-foreground
                            hover:text-background hover:bg-foreground
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 00">Modificar</Link>
                    </td>
                </template>
            </DataTable>
            <Paginator :pages="teachers.links" />
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import DataTable from '@/components/DataTablet.vue'
import Paginator from '@/components/Paginator.vue';
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    teachers: {
        type: Array,
        required: true,
    },
});

const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth <= 640;
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

const headers = computed(() => {
    return isMobile.value
        ? ['Nombre', 'Apellido', 'Acciones']
        : ['ID', 'Nombre', 'Apellido', 'Teléfono', 'Acciones'];
});
</script>
