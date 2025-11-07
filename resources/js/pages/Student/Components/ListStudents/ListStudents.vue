<script setup lang="ts">
import Table from '@/components/Table/Table.vue';
import TableData from '@/components/Table/TableData.vue';
import Paginator from '@/components/Paginator.vue';
import { Pagination } from '@/types/dtos';
import { Student } from '@/types/dtos';
import { computed, onMounted, ref } from 'vue';

const props = defineProps<{
    students: Pagination<Student>
}>()

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
        ? ['Nombre y Apellido', 'Cedula Escolar']
        : ['Nombre y Apellido', 'Cedula Escolar'];
});

</script>


<template>
    <Table :items="props.students.data" :headers="headers">
        <template #body="{ item }">
            <TableData>{{ item.name + item.surname }}</TableData>
            <TableData :key="item.id">
                {{ item.schoolId }}
            </TableData>
        </template>
    </Table>
    <Paginator :pages="students.links" />
</template>