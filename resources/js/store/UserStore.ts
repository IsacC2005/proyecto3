import { useForm } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import { ref } from "vue";



export const useUserStore = defineStore('user-store', () => {

    const form = useForm({
        roleId: 0,
        name: '',
        email: '',
        password: ''
    })

    const repeatPassword = ref('');

    const somePassword = (): boolean => {
        return form.password === repeatPassword.value ? true : false;
    }

    const cleanPassword = () => {
        form.password = '';
        repeatPassword.value = '';
    }

    const resetForm = () => {
        repeatPassword.value = ''
        form.reset();
    }

    return { form, resetForm, repeatPassword, somePassword, cleanPassword };
});