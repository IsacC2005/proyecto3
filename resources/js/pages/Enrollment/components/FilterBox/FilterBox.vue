<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import { Section } from '@/types/dtos';
import { router } from '@inertiajs/vue3';
import FilterGrade from './FilterGrade.vue';
import FilterContentTeacher from './FilterContentTeacher.vue';
import FilterContentStudent from './FilterContentStudent.vue';
import FilterYear from './FilterYear.vue';

const props = defineProps<{
    sections: Section[]
    schoolYear: string
}>()

const emits = defineEmits(['filtered']);

const open = ref(false);

const selectGrade = ref(null);

const selectMoment = ref(null);

const selectContentTeacher = ref(null);

const selectContentStudent = ref(null);

watch([selectGrade, selectMoment, selectContentTeacher, selectContentStudent], () => {
    emits('filtered', filter());
});

onMounted(() => {
    emits('filtered', filter());
})


const filterYear = (schoolYear: string) => {
    router.get('/enrollment/index', { 'schoolYear': schoolYear }, {
    })
    console.log(schoolYear)
}

const filter = () => {
    const filteredSections = props.sections.filter((section) => {
        return passeGradeFilter(section) &&
            passeContentTeacherFilter(section) &&
            passeContentStudentFilter(section) &&
            passeMomentFilter(section);
    })
    return filteredSections;
}

const passeGradeFilter = (section: Section): boolean => {
    return selectGrade.value === null || section.grade === selectGrade.value;
}

const passeMomentFilter = (section: Section): boolean => {
    return selectMoment.value === null || section.schoolMoment == selectMoment.value;
}

const passeContentTeacherFilter = (section: Section): boolean => {
    if (selectContentTeacher.value === null) {
        return true;
    }

    if (selectContentTeacher.value === true) {
        return section.teacher !== null;
    }

    if (selectContentTeacher.value === false) {
        return section.teacher === null;
    }

    return false;
}

const passeContentStudentFilter = (section: Section): boolean => {
    if (selectContentStudent.value === null) {
        return true;
    }

    if (selectContentStudent.value === true) {
        return section.students.length > 0;
    }

    if (selectContentStudent.value === false) {
        return section.students.length === 0;
    }

    return false;
}

const clearFilter = () => {
    selectGrade.value = null;
    selectMoment.value = null;
    selectContentTeacher.value = null;
    selectContentStudent.value = null;
    emits('filtered', props.sections);
}

</script>

<template>
    <button @click="open = !open" class="w-fit py-2 px-5 ml-4 mb-4 font-semibold text-blue-950 font-sans 
        bg-gradient-to-l from-primary to-primary/60
        hover:from-primary/60 hover:to-primary
        hover:scale-95
        transition duration-300 ease-in-out
        shadow-lg hover:shadow-xl focus:shadow-md active:shadow-sm
        rounded-2xl flex flex-row">
        <spam>Filtrar</spam>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
            viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
        </svg>
    </button>
    <FilterYear @filterYear="filterYear($event)" :schoolYear="props.schoolYear" />

    <div v-if="open" class="
    w-full m-0 sm:w-250 sm:m-auto
    flex flex-row flex-wrap justify-center items-center
     bg-background shadow-2xl rounded-2xl">
        <h2 class="w-full mt-5 px-3 text-2xl text-left font-semibold text-blue-950 font-sans">Filtrar por</h2>
        <button @click="clearFilter" class=" w-fit py-2 px-5 ml-4 mb-4 font-semibold text-blue-950 font-sans 
        bg-gradient-to-l from-destructive to-destructive/60
        hover:from-destructive/60 hover:to-destructive
        hover:scale-95
        transition duration-300 ease-in-out
        shadow-lg hover:shadow-xl focus:shadow-md active:shadow-sm
        rounded-2xl flex flex-row">Limpiar filtro</button>
        <div class="
        m-10
        flex flex-row gap-4 justify-center items-center flex-wrap">
            <FilterGrade @filter-grade="selectGrade = $event" />
            <FilterContentStudent @select="selectContentStudent = $event" />
            <FilterContentTeacher @select="selectContentTeacher = $event" />
        </div>
    </div>
</template>