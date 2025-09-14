<template>

    <thead class="bg-gray-50">
        <tr>
            <th rowspan="2"
                class="sticky-col-student px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky-col-student">
                Estudiantes
            </th>
            <th class="border border-black" :colspan="referent.indicators.length" v-for="referent in data.referents"
                :key="referent.id">
                {{ referent.title }}
            </th>
        </tr>
        <tr>
            <template v-for="referent in data.referents" :key="referent.id">
                <th v-for="indicator in referent.indicators" :key="indicator.id">
                    {{ indicator.name }}
                </th>
            </template>
        </tr>
    </thead>
</template>

<script setup lang="ts">
import { useAllNoteStore } from '@/store/AllNoteStore';
const data = useAllNoteStore();
</script>

<style scoped>
.sticky-col-student {
    position: sticky;
    left: 0;
    z-index: 10;
    background-color: #f9fafb;
    border-right: 1px solid #e5e7eb;
}
</style>