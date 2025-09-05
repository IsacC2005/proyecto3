<template>
    <div>
        <template v-for="(dailyClass, index) in props.dailyClasses" :key="index">
            <CreateClass :index="2" :dailyClass="dailyClass"></CreateClass>
        </template>
    </div>
</template>

<script setup lang="ts">
import CreateClass from './CreateClass.vue';
import Button from '@/components/ui/button/Button.vue';

const props = defineProps<{
    dailyClasses: DailyClass[]
}>();

type DailyClass = {
    title: string,
    content: string,
    date: Date
}
</script>
