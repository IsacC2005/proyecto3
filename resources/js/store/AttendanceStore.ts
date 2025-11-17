import { useForm } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useAttendanceStore = defineStore('attendance-store', () => {

    const form = useForm({
        projectId: 0,
        studentId: 0
    })

    const resetForm = () => {
        form.reset();
    }

    interface attendance {
        studentId: number,
        attendance: boolean
    }

    const attendances = ref([] as attendance[])

    return { form, resetForm, attendances }
})