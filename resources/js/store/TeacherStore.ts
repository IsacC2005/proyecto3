import { defineStore } from "pinia";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

export const useTeacherStore = defineStore('teacher-store', () => {

    interface Teacher {
        id: number,
        name: string,
        surname: string,
        phone: string,
        email: string,
        password: string,
        [key: string]: any
    }

    const initialForm: Teacher = {
        id: 0,
        name: '',
        surname: '',
        phone: '',
        email: '',
        password: ''
    }

    const repeatPassword = ref('');

    const somePassword = (): boolean => {
        return form.password === repeatPassword.value ? true : false;
    }

    const cleanPassword = () => {
        form.password = '';
        repeatPassword.value = '';
    }

    const form = useForm(initialForm);

    const resetForm = () => {
        repeatPassword.value = ''
        form.reset();
    }

    return { form, resetForm, repeatPassword, somePassword, cleanPassword }
});

export const useCreateUserForTeacher = defineStore('create-user-for-teacher', () => {
    const form = useForm({
        id: 577,
        name: 's',
        email: '',
        password: ''
    })

    const repeatPassword = ref('');

    return { form, repeatPassword }
})