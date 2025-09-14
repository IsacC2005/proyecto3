<template>
    <AppLayout>
        <div class="p-6 md:p-8 lg:p-10">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 text-gray-800">Notas de Clase</h1>

            <div class="bg-white rounded-lg shadow-md p-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th rowspan="2"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky-col-student">
                                Estudiantes
                            </th>
                            <template v-for="clase in classesWithIndicators" :key="clase.id">
                                <th @click="toggleCollapse(clase.id)"
                                    :colspan="isCollapsed(clase.id) ? 1 : clase.indicators.length"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l border-gray-200 cursor-pointer">
                                    {{ clase.title }}
                                    <span class="ml-2">{{ isCollapsed(clase.id) ? '▶' : '▼' }}</span>
                                </th>
                            </template>
                        </tr>
                        <tr>
                            <template v-for="clase in classesWithIndicators" :key="clase.id">
                                <template v-if="!isCollapsed(clase.id)">
                                    <th v-for="indicator in clase.indicators" :key="indicator.id"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ indicator.name }}
                                    </th>
                                </template>
                            </template>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="student in uniqueStudents" :key="student.id">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky-col-student">
                                {{ student.name }}
                            </td>
                            <template v-for="clase in classesWithIndicators" :key="clase.id">
                                <template v-if="!isCollapsed(clase.id)">
                                    <td v-for="indicator in clase.indicators" :key="indicator.id"
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ getNoteForStudentIndicatorAndClass(student.id, clase.id, indicator.id) }}
                                    </td>
                                </template>
                            </template>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

interface Student {
    id: number;
    name: string
}

interface Note {
    id: number;
    referentId: number;
    note: string
}

interface ListNote {
    student: Student;
    note: Note

}

interface Referent {
    id: number;
    title: string;
    indicators: Indicator[]
}

interface Indicator {
    id: number;
    name: string;
}

interface Props {
    data: {
        projectId: number;
        classes: Referent[];
        notes: ListNote[];
    };
}

const props = defineProps<Props>();

// Estado local para manejar las clases colapsadas
const collapsedClasses = ref<number[]>([]);

const allNotes = computed<Note[]>(() => props.data.notes || []);
const allIndicators = computed<Indicator[]>(() => props.data.indicators || []);

const uniqueStudents = computed(() => {
    const students: { id: number; name: string }[] = [];
    const studentIds = new Set<number>();
    allNotes.value.forEach(note => {
        if (!studentIds.has(note.student_id)) {
            studentIds.add(note.student_id);
            students.push({ id: note.student_id, name: note.student_name });
        }
    });
    return students;
});

const classesWithIndicators = computed(() => {
    return props.data.classes.map(clase => {
        const classIndicatorIds = new Set(allNotes.value
            .filter(note => note.daily_class_id === clase.id)
            .map(note => note.evaluation_item_id)
        );

        const indicatorsForClass = allIndicators.value
            .filter(indicator => classIndicatorIds.has(indicator.id))
            .sort((a, b) => a.id - b.id);

        return {
            ...clase,
            indicators: indicatorsForClass,
        };
    });
});

const isCollapsed = (classId: number) => {
    return collapsedClasses.value.includes(classId);
};

const toggleCollapse = (classId: number) => {
    const index = collapsedClasses.value.indexOf(classId);
    if (index > -1) {
        collapsedClasses.value.splice(index, 1);
    } else {
        collapsedClasses.value.push(classId);
    }
};

const getNoteForStudentIndicatorAndClass = (studentId: number, classId: number, indicatorId: number) => {
    const note = allNotes.value.find(
        n =>
            n.student_id === studentId &&
            n.daily_class_id === classId &&
            n.evaluation_item_id === indicatorId
    );
    return note ? note.note : '-';
};
</script>

<style scoped>
.sticky-col-student {
    position: sticky;
    left: 0;
    z-index: 10;
    background-color: #f9fafb;
    border-right: 1px solid #e5e7eb;
}
</style>