import { Student } from "@/types/dtos";
import { defineStore } from "pinia";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

export const useQualitesStore = defineStore('qualities-store', () => {

    const students = ref([] as Student[])
    const qualities = ref([] as qualitiesType[])

    const evaluate = (qualitieId?: number, learningProjectId: number, studentId: number, qualitieName?: string) => {
        router.post('/test', {
            student_id: studentId,
            learning_project_id: learningProjectId,
            qualitie_id: qualitieId,
            qualitie_name: qualitieName
        }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }

    const evaluateStatus = (learningProjectId: number, studentId: number) => {
        router.post('/test/status', {
            student_id: studentId,
            learning_project_id: learningProjectId,
        }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }


    return { students, qualities, evaluate, evaluateStatus }
})

export type qualitie = {
    id: number,
    name: string
}

export type qualitiesType = {
    id: number
    name: string
    qualities: qualitie[]
}