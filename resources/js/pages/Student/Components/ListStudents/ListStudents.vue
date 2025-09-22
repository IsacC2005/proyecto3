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
        ? ['Grado', 'Nombre', 'Apellido', 'Acciones']
        : ['Grado', 'Nombre', 'Apellido', 'Acciones'];
});

</script>


<template>
    <Table :items="props.students.data" :headers="headers">
        <template #body="{ item }">
            <TableData>{{ item.grade }} <p class="inline-block" v-if="!isMobile">ㅤGrado
                </p>
            </TableData>
            <TableData>{{ item.name }}</TableData>
            <TableData>{{ item.surname }}</TableData>
            <TableData :key="item.id">
                <a :href="`/teacher/edit/${item.id}`" class="
                            text-foreground
                            border border-muted-foreground
                            hover:text-background hover:bg-foreground
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 00">Modificar</a>
            </TableData>
        </template>
    </Table>
    <Paginator :pages="students.links" />
</template>