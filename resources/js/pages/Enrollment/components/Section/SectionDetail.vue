<template>
    <div>
        <SectionDetailStudents :students="props.section.students">
            <Link
                class="mt-1 px-2 py-1 text-center bg-emerald-700 text-white text-xs md:text-sm font-bold rounded-full hover:bg-emerald-800 transition-colors duration-200"
                href="/enrollment/add-student/" :data="{ enrollmentId: props.section.id }">
            Agregar
            </Link>
        </SectionDetailStudents>
    </div>
    <SectionDetailTeacher :section="props.section" />
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Section } from '@/types/dtos';
import { Link } from '@inertiajs/vue3';
import SectionDetailStudents from './SectionDetailStudents.vue';
import SectionDetailTeacher from './SectionDetailTeacher.vue';

const props = defineProps<{
    section: Section
}>()
</script>
