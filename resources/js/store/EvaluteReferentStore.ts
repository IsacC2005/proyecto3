import { defineStore } from "pinia";
import { DailyClass, Student } from "@/types/dtos";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

export type noteValue = 'PL' | 'L' | 'EP' | 'PM' | 'NL' | '';

export interface indicatorNote {
    [indicatorId: number]: { note: noteValue }
}

export interface Notes {
    [studentId: number]: indicatorNote[]
}

export const useEvaluateStore = defineStore("evaluate", {
    state: () => {
        const students = ref<Student[]>();
        const referent = ref<DailyClass>();
        const notes = ref<Notes[]>();
        return { students, referent, notes };
    },
    actions: {
        saveNote(studentId: number, indicatorId: number, Note: noteValue) {

            if (this.notes) {

                const studentNotes = this.notes[studentId];

                if (!studentNotes) {
                    this.notes[studentId] = [];
                    // this.notes[studentId][indicatorId]
                    this.notes[studentId][indicatorId] = Note
                } else {
                    studentNotes[indicatorId] = Note;
                }
            }
            router.post('/teacher/evaluate/class/save', {
                studentId: studentId,
                evaluationId: this.referent?.id,
                indicatorId: indicatorId,
                note: Note,
            }, {
                preserveState: true,
                preserveScroll: true,
                replace: true,
                only: ['students', 'dailyClass', 'allNote']
            });

        },
    }

});
