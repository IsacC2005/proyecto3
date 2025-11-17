import { defineStore } from "pinia";
import { DailyClass, Student } from "@/types/dtos";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

export type noteValue = 'PL' | 'L' | 'EP' | 'PM' | 'SL' | '';

export interface indicatorNote {
    [indicatorId: number]: { note: noteValue }
}

export interface Notes {
    [studentId: number]: indicatorNote[]
}

export const useEvaluateStore = defineStore("evaluate", {
    state: () => {
        const students = ref<Student[]>();
        const studentsFilters = ref<Student[]>();
        const referent = ref<DailyClass>();
        const notes = ref<Notes[]>();
        return { students, referent, notes, studentsFilters };
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
        filterByName(name: string) {
            const nameSearch = name.toLowerCase().trim();

            if (!nameSearch) {
                this.studentsFilters = this.students;
                return;
            }

            this.studentsFilters = this.students?.filter(student => {
                const nameNormalized = student.name.toLowerCase().trim()
                const surnameNormalized = student.surname.toLowerCase().trim()

                return nameNormalized.includes(nameSearch) || surnameNormalized.includes(nameSearch)
            })
        }
    }

});
