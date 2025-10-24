<template>
    <Table :headers="headers" :items="props.pagination.data">
        <template #body="{ item }">
            <TableDate v-if="!isMobile">{{ item.id }}</TableDate>
            <TableDate>{{ item.name }}</TableDate>
            <TableDate>{{ item.surname }}</TableDate>
            <TableDate v-if="!isMobile">{{ item.phone }}</TableDate>
            <TableDate>
                <template v-if="item.userId">
                    <TableButton :name="`Ver Usuario`" :route="`/teacher/create-user/${item.id}`"
                        class="bg-green-500 hover:bg-green-600 transition-colors ease-in-out" />
                </template>
                <template v-else>
                    <TableButton :name="`Crear Usuario`" :route="`/teacher/create-user/${item.id}`" />
                </template>
            </TableDate>
        </template>
    </Table>
</template>

<script setup lang="ts">
import Table from '@/components/Table/Table.vue';
import { Pagination, Teacher } from '@/types/dtos';
import { computed, onMounted, ref } from 'vue';
import { defineProps } from 'vue';
import TableDate from '@/components/Table/TableData.vue';
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
