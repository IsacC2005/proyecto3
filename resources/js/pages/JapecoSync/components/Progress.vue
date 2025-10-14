<script setup lang="ts">
import { computed } from 'vue';


const props = defineProps<{
    isSyncing: boolean
    syncProgress: number
    syncMessage: string
}>();


const progressColor = computed(() => {
    if (props.syncProgress === 100) return 'bg-green-500';
    if (props.isSyncing) return 'bg-blue-500';
    return 'bg-indigo-400';
});
</script>

<template>
    <div class="mb-8">
        <div class="flex justify-between mb-1 text-sm font-medium text-gray-700">
            <span>Progreso de la Sincronización</span>
            <span :class="{ 'text-green-600': syncProgress === 100 }">{{ syncProgress }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div :class="[progressColor, 'h-2.5 rounded-full transition-all duration-500 ease-out']"
                :style="{ width: syncProgress + '%' }">
            </div>
        </div>
        <p v-if="isSyncing" class="mt-2 text-sm text-blue-600 animate-pulse">
            {{ syncMessage }}
        </p>
        <p v-else-if="syncProgress === 100" class="mt-2 text-sm text-green-600">
            {{ syncMessage }}
        </p>
        <p v-else-if="syncProgress > 0" class="mt-2 text-sm text-gray-500">
            {{ syncMessage }}
        </p>
    </div>
</template>