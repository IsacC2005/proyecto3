<script setup lang="ts">
import InputPersonalData from './InputPersonalData/InputPersonalData.vue';
import InputAccessData from './InputAccessData/InputAccessData.vue';
</script>


<template>
    <form>
        <InputPersonalData />
        <InputAccessData />
        <slot />
    </form>
</template>