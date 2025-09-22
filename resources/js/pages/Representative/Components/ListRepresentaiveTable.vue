<script setup lang="ts">
import Table from '@/components/Table/Table.vue';
import TableData from '@/components/Table/TableData.vue';
import Button from '@/components/ui/button/Button.vue';
import Paginator from '@/components/Paginator.vue';
import { Pagination } from '@/types/dtos';
import { Representative } from '@/types/dtos';
import { computed, onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    representatives: Pagination<Representative>
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
        ? ['Cedula', 'Nombre', 'Apellido', 'telefono', 'Acciones']
        : ['Cedula', 'Nombre', 'Apellido', 'telefono', 'direccion', 'Acciones'];
});

</script>


<template>
    <Table :items="props.representatives.data" :headers="headers">
        <template #body="{ item }">
            <TableData>{{ item.idcard }}</TableData>
            <TableData>{{ item.name }}</TableData>
            <TableData>{{ item.surname }}</TableData>
            <TableData>{{ item.phone }}</TableData>
            <TableData>{{ item.direction }}</TableData>
            <TableData :key="item.id">
                <Link href="/student/create/" :data="{ idcard: item.idcard }">
                <Button>
                    Add Estudiante
                </Button>
                </Link>
            </TableData>
        </template>
    </Table>
    <Paginator :pages="representatives.links" />
</template>