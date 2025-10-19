<template>
    <TransitionRoot :show="isOpen" as="template" class="relative z-9999">
        <Dialog @close="closeAlert">
            <TransitionChild enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black/30" />
            </TransitionChild>

            <TransitionChild enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95" class="fixed inset-0 flex items-center justify-center p-4">
                <DialogPanel :class="panelClass" class="w-full max-w-sm rounded p-6">
                    <DialogTitle class="text-xl font-semibold font-[Montserrat]">{{ title }}</DialogTitle>
                    <DialogDescription class="mt-2 text-sm text-gray-500 font-[Montserrat]">
                        {{ description }}
                    </DialogDescription>

                    <p class="mt-4 text-sm font-medium font-[Montserrat]" :class="messageClass">
                        {{ message }}
                    </p>

                    <div class="mt-4 flex justify-end">
                        <button @click="closeAlert" :class="buttonClass"
                            class="py-1 px-5 font-black hover:rounded focus:outline-none rounded">
                            Okey
                        </button>
                    </div>
                </DialogPanel>
            </TransitionChild>
        </Dialog>
    </TransitionRoot>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogDescription,
    DialogTitle,
} from '@headlessui/vue'
import { useAlertData } from '@/store/ModalStore';
import { storeToRefs } from 'pinia';
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Alert } from '@/types';

const page = usePage();

const data = useAlertData();
const { isOpen, title, description, message, code } = storeToRefs(data);
const { showAlert, closeAlert } = data;

const alertFlash = computed(() => page.props.flash?.alert);

onMounted(() => {
    openAlert();
})

watch(alertFlash, () => {
    openAlert();
});

const openAlert = () => {
    const data = page.props.flash.alert;
    if (data) {
        const dataAlert: Alert = {
            isOpen: false,
            title: data.title,
            description: data.description,
            message: data.message,
            code: data.code
        }
        showAlert(dataAlert);
    }
}

// Dynamic classes based on code
const panelClass = computed(() =>
    code.value == 400
        ? 'bg-red-100'
        : 'bg-white'
);

const messageClass = computed(() =>
    code.value == 400
        ? 'text-red-700'
        : 'text-gray-700'
);

const buttonClass = computed(() =>
    code.value == 400
        ? 'bg-red-500/30 text-red-900 hover:bg-red-500/50'
        : 'bg-emerald-500/30 text-emerald-900 hover:bg-emerald-500/50'
);
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap");
</style>