<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue';

type option = {
    id: number | null,
    name: string
}


const props = defineProps<{ options: option[], name: String }>();

const name = ref('');

onMounted(() => {
    name.value = props.name.toString()
})

const selected = ref();

const emits = defineEmits(['select']);

watch(selected, (newValue) => {
    name.value = selected.value.name.toString();
    emits('select', newValue.id);
});

</script>

<template>
    <div class="w-full max-w-xs mx-auto">
        <Listbox v-model="selected">
            <div class="relative mt-1">
                <ListboxButton
                    class="relative w-full cursor-default rounded-2xl bg-white border-2 border-blue-400 py-2 pl-3 pr-10 text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-300 sm:text-sm">
                    <span class="block truncate">{{ name }}</span>
                    <!-- Ícono de flecha que indica que es un selector -->
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </ListboxButton>

                <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <ListboxOptions
                        class="absolute z-100 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">

                        <ListboxOption v-for="option in props.options" :key="option.id" :value="option"
                            v-slot="{ active, selected }" as="template">
                            <li :class="[
                                active ? 'bg-amber-100 text-amber-900' : 'text-gray-900',
                                'relative cursor-default select-none py-2 pl-10 pr-4',
                            ]">
                                <span :class="[
                                    selected ? 'font-medium' : 'font-normal',
                                    'block truncate',
                                ]">{{ option.name }}</span>

                                <span v-if="selected"
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </li>
                        </ListboxOption>
                    </ListboxOptions>
                </transition>
            </div>
        </Listbox>
    </div>
</template>