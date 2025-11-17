<template>
    <form class="mt-4">
        <InputName />
        <InputDate />
        <SelectTrainingArea />
        <InputDevelopment />
        <InputIndicators />
        <slot />
    </form>
</template>

<script setup lang="ts">
import InputName from './InputName.vue';
import InputDevelopment from './InputDevelopment.vue';
import InputIndicators from './InputIndicators.vue';
import InputDate from './InputDate.vue';
import SelectTrainingArea from './SelectTrainingArea.vue';




</script>