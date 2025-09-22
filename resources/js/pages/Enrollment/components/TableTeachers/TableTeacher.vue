<template>
    <Table :headers="headers" :items="props.pagination.data">
        <template #body="{ item }">
            <TableDate v-if="!isMobile">{{ item.id }}</TableDate>
            <TableDate>{{ item.name }}</TableDate>
            <TableDate>{{ item.surname }}</TableDate>
            <TableDate v-if="!isMobile">{{ item.phone }}</TableDate>
            <TableDate>
                <TableTeacherButton :enrollmentId="props.sectionId" :teacherId="item.id" />
            </TableDate>
        </template>
    </Table>
</template>

<script setup lang="ts">
import Table from '@/components/Table/Table.vue';
import TableDate from '@/components/Table/TableData.vue';
import { Pagination, Teacher } from '@/types/dtos';
import { computed, onMounted, ref } from 'vue';
import TableTeacherButton from './TableTeacherButton.vue';


type HeaderTable = string[];

const props = defineProps<{
    pagination: Pagination<Teacher>,
    sectionId: number
}>();

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
