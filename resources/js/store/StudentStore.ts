import { useForm } from "@inertiajs/vue3";
import { defineStore } from "pinia";

export const useStudentStore = defineStore('student-store', () => {
    interface student {
        id: number;
        name: string;
        surname: string;
        grade: number;
        representativeId: number;
        [key: string]: any
    }

    const initialForm: student = {
        id: 0,
        name: '',
        surname: '',
        grade: 0,
        representativeId: 1
    }

    const form = useForm(initialForm)

    const cleanForm = () => {
        form.reset();
    }

    return { form, cleanForm };
})