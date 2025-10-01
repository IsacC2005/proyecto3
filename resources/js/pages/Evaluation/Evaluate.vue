<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import ListStudentEvaluate from './components/ListStudentEvaluate.vue';
import { DailyClass, Student } from '@/types/dtos';
import { useEvaluateStore } from '@/store/EvaluteReferentStore';
import { Notes } from '@/store/EvaluteReferentStore';
import { noteValue } from '@/store/EvaluteReferentStore';

interface NoteDisorder {
    note: noteValue;
    itemEvaluationId: number;
    studentId: number;
}

const evaluateReferent = useEvaluateStore();

const props = defineProps<{
    dailyClass: DailyClass,
    students: Student[],
    allNote: NoteDisorder[],
}>()

onMounted(() => {
    evaluateReferent.students = props.students;
    evaluateReferent.referent = props.dailyClass;
    console.log(groupNotes(props.allNote));
    evaluateReferent.notes = groupNotes(props.allNote);

});

type GroupNotes = Notes[]

function groupNotes(notesArray: NoteDisorder[]) {
    return notesArray.reduce((acc: GroupNotes, note) => {
        const studentId: number = note.studentId;
        const indicatorId: number = note.itemEvaluationId;

        if (!acc[studentId]) {
            acc[studentId] = [];
        }

        acc[studentId][indicatorId] = note.note as noteValue;

        return acc;
    }, {} as GroupNotes);
}
</script>

<template>
    <AppLayout>
        <div v-if="!props.dailyClass?.indicators.length">
            <Heading title="Esta Clase no tiene indicadores"
                description="primero tienes que agregar los indicadores de esta clase para poder evaluarla"></Heading>
            <Link :href="`/daily-class/edit/${props.dailyClass.id}`"
                class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors duration-200">
            Agregar indicadores
            </Link>

        </div>
        <div v-else>
            <Heading title="Lista de estudiantes para evaluar"></Heading>
            {{ props.allNote }}
            <div class="p-4 sm:p-6 md:p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <ListStudentEvaluate>
                    </ListStudentEvaluate>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
