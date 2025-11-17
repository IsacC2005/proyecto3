<script setup lang="ts">
import { Student } from '@/types/dtos';

const props = defineProps<{
    student: Student
}>();

const emit = defineEmits(['toggleAttendance'])

</script>

<template>
    <div @click="emit('toggleAttendance', props.student.id)"
        class="flex items-center justify-between p-4 rounded-lg cursor-pointer transition-all duration-300 ease-in-out border-l-4 shadow-sm hover:shadow-md"
        :class="{
            'bg-green-50 border-green-500': props.student.name === 'present',
            'bg-red-50 border-red-500 opacity-60': 'absent' === 'absent',
            'bg-gray-50 border-gray-400': props.student.name === 'pending'
        }">

        <!-- Información del estudiante -->
        <div class="flex-grow">
            <span class="font-medium text-gray-800">{{ props.student.name }} {{ student.surname }}</span>
        </div>

        <!-- Indicador de estado -->
        <div class="flex-shrink-0 ml-4">
            <div class="w-5 h-5 rounded-full" :class="{
                'bg-green-500': props.student.name === 'present',
                'bg-red-500': 'absent' === 'absent',
                'bg-gray-400': props.student.name === 'pending'
            }">
            </div>
        </div>
    </div>
</template>