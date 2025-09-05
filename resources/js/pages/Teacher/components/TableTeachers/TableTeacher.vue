<template>
    <Table :headers="headers" :items="props.pagination.data">
        <template #body="{ item }">
            <TableDate v-if="!isMobile">{{ item.id }}</TableDate>
            <TableDate>{{ item.name }} ss</TableDate>
            <TableDate>{{ item.surname }}</TableDate>
            <TableDate v-if="!isMobile">{{ item.phone }}</TableDate>
            <TableDate>
                <TableButton :data="{ teacherId: item.id }" :name="`Modificar`" :route="`/teacher/edit`">

                </TableButton>
            </TableDate>
        </template>
    </Table>
</template>

<script setup lang="ts">
import Table from '@/components/Table/Table.vue';
import { Pagination, Teacher } from '@/types/dtos';
import { computed, onMounted, ref } from 'vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import TableDate from '@/components/Table/TableDate.vue';
import TableButton from '@/components/Table/TableButton.vue';

const props = defineProps<{
    pagination: Pagination<Teacher>
}>()

type HeaderTable = string[];

const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth <= 640;
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});



const headers = computed((): HeaderTable => {
    return isMobile.value
        ? ['Nombre', 'Apellido', 'Acciones']
        : ['ID', 'Nombre', 'Apellido', 'Teléfono', 'Acciones'];
});
</script>
