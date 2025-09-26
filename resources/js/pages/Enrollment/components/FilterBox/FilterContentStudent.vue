<script setup lang="ts">
import { ref, watch } from 'vue';
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue';
import Label from '@/components/ui/label/Label.vue';

const options = [
    { name: 'Todos', value: null },
    { name: 'Con Estudiantes', value: true },
    { name: 'Sin Estudiantes', value: false },
];

const selectedOption = ref(options[2].value);

const emits = defineEmits(['select']);

watch(selectedOption, (newValue) => {
    emits('select', newValue);
});
</script>

<template>
    <Label
        class="relative w-fit m-2 p-2 pb-4 flex flex-col items-center border border-t-0 border-x-0 border-b-gray-400">
        <span class="absolute -bottom-1.5 left-0 px-1 bg-background text-[0.8rem] text-gray-400">Estudiantes</span>
        <div class="w-fit">
            <RadioGroup v-model="selectedOption">
                <div class="flex justify-center items-center gap-1">
                    <template v-for="option in options" :key="option.name">
                        <RadioGroupOption as="template" :value="option.value" v-slot="{ active, checked }">
                            <div class="w-max flex items-center justify-between h-11 pr-2 border-2 border-blue-500 rounded-4xl select-none cursor-pointer transition-all"
                                :class="checked ? 'bg-blue-400' : ''">
                                <div>
                                    <svg v-if="checked" class="h-10 w-full text-background" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="flex flex-1">
                                        <RadioGroupLabel as="span" class="block pl-2 text-sm font-medium text-gray-900">
                                            {{
                                                option.name }}</RadioGroupLabel>

                                    </span>
                                </div>

                            </div>
                        </RadioGroupOption>
                    </template>
                </div>
            </RadioGroup>
        </div>
    </Label>
</template>