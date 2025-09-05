<template>
    <Link :href="`/teacher/evaluate/class`" :data="{ classId: props.evaluation.id }"
        class="card w-full sm:w-80 p-6 rounded-lg shadow-lg dark:bg-gray-800 transition-transform duration-300 hover:scale-105"
        :class="getCardColor(props.evaluation.date.date)">

    <h3 class="font-bold text-xl mb-2">{{ props.evaluation.title }}</h3>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ formatDate(props.evaluation.date.date) }}</p>

    <p v-if="props.evaluation.content" class="text-gray-700 dark:text-gray-300 mb-4">
        {{ props.evaluation.content }}
    </p>

    <div v-if="props.evaluation.learningProject" class="learning-project">
        <span class="font-semibold">Proyecto de aprendizaje:</span>
        <p>{{ props.evaluation.learningProject.title }}</p>
    </div>
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { DailyClass } from '@/types/dtos';

const props = defineProps<{
    evaluation: DailyClass
}>();

const formatDate = (dateString: string) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('es-ES', options);
};

const getCardColor = (dateString: string) => {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const evaluationDate = new Date(dateString);
    evaluationDate.setHours(0, 0, 0, 0);

    if (evaluationDate > today) {
        return 'bg-green-100 dark:bg-green-800 dark:text-gray-100'; // Futuro
    } else if (evaluationDate.getTime() === today.getTime()) {
        return 'bg-blue-100 dark:bg-blue-800 dark:text-gray-100'; // Hoy
    } else {
        return 'bg-gray-200 dark:bg-gray-700 dark:text-gray-300'; // Pasado
    }
};
</script>

<style scoped>
.card {
    min-width: 300px;
    max-width: 400px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>