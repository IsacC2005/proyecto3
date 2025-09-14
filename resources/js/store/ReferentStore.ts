import { defineStore } from "pinia";
import { useForm } from "@inertiajs/vue3";

export const useReferenStore = defineStore('referent-store', () => {
    const form = useForm({
        projectId: 0,
        title: '',
        content: '',
        date: new Date,
        indicators: [{ title: '' }]
    })

    const resetForm = () => {
        form.reset();
    }

    const addIndicator = (Indicator: string) => {
        form.indicators.push({ title: Indicator })
    }

    const removeIndicator = (index: number) => {
        form.indicators.splice(index, 1);
    };

    return { form, resetForm, addIndicator, removeIndicator };
})