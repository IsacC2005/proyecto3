<template>
    <Table :items="props.pagination.data" :headers="headers">
        <template #body="{ item }">
            <TableDate>{{ grade[0][item.grade] }}</TableDate>
            <TableDate>{{ item.name }}</TableDate>
            <TableDate>{{ item.surname }}</TableDate>
            <TableDate>
                <TableStudentsButton :studentId="item.id" :enrollmentId="props.section.id"
                    :addSection="props.section.students.includes(item.id)">
                </TableStudentsButton>
            </TableDate>
        </template>
    </Table>

    <div class="mt-8 flex justify-center">
        <Paginator :pages="props.pagination.links" />
    </div>
</template>

<script setup lang="ts">
import Table from '@/components/Table/Table.vue';
import Paginator from '@/components/Paginator.vue';
import TableDate from '@/components/Table/TableDate.vue';
import { Pagination, Section, Student } from '@/types/dtos';
import TableStudentsButton from './TableStudentsButton.vue';

const props = defineProps<{
    pagination: Pagination<Student>;
    section: Section;
}>();

const headers = [
    'Grado',
    'Nombre',
    'Apellido',
    'Acciones'
];

const grade = [
    {
        0: 'Preescolar',
        1: 'Primer Grado',
        2: 'Segundo Grado',
        3: 'Tercer Grado',
        4: 'Cuarto Grado',
        5: 'Quinto Grado',
        6: 'Sexto Grado'
    }
];

function isNumberArray(arr: any): arr is number[] {
    return Array.isArray(arr) && (arr.length === 0 || typeof arr[0] === 'number');
}
</script>
