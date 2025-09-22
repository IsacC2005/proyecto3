<script setup lang="ts">
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';

type sections = {
    grade: number;
    section: string;
    selected: boolean;
}

const formBatch = ref({
    sections: [] as sections[],
});

const grades = [1, 2, 3, 4, 5, 6];
const sections = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];

grades.forEach(grade => {
    sections.forEach(section => {
        formBatch.value.sections.push({ grade: grade, section, selected: false });
    });
});

const handleCheckboxChange = (grade: number, section: string) => {
    const selectedIndex = sections.indexOf(section);

    if (formBatch?.value.sections.find(g => g.grade === grade && g.section === section)?.selected) {
        for (let i = 0; i < selectedIndex; i++) {
            const prevSection = sections[i];
            const prevItem = formBatch?.value.sections.find(g => g.grade === grade && g.section === prevSection);
            if (prevItem) {
                prevItem.selected = true;
            }
        }
    }
};

const createLot = () => {
    const selectedSections = formBatch.value.sections
        .filter(item => item.selected)
        .map(item => ({
            grade: item.grade,
            section: item.section,
        }));

    if (selectedSections.length === 0) {
        alert('Seleccione al menos una sección para crear matrículas por lotes.');
        return;
    }

    formBatch.value.sections = formBatch.value.sections.map(item => ({
        ...item,
        selected: false,
    }));
    const form = useForm({
        lot: [
            {
                grade: 0,
                section: '',
            },
        ]
    })

    form.lot = selectedSections
    form.post('/enrollment/createLot');
    console.log('Secciones seleccionadas para crear matrículas por lotes:', selectedSections);
};
</script>



<template>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Grado</th>
                <th v-for="section in sections" :key="section" scope="col" class="px-6 py-3 text-center">
                    {{ section }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="grade in grades" :key="grade"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ grade }}° Grado
                </td>
                <td v-for="section in sections" :key="section" class="px-6 py-4 text-center">
                    <input type="checkbox" :value="`${grade}${section}`"
                        v-model="formBatch.sections.find(g => g.grade === grade && g.section === section).selected"
                        @change="handleCheckboxChange(grade, section)"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </td>
            </tr>
        </tbody>
    </table>

    <button @click="createLot"
        class="mt-4 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
        Crear Matrículas por Lotes
    </button>
</template>
