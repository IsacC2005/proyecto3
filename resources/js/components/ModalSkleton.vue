<template>
    <!-- Wrap your dialog in a `TransitionRoot`. -->
    <TransitionRoot :show="isOpen" as="template" class="relative z-50">
        <Dialog @close="closeAlert">
            <!-- Wrap your backdrop in a `TransitionChild`. -->
            <TransitionChild enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black/30" />
            </TransitionChild>

            <!-- Wrap your panel in a `TransitionChild`. -->
            <TransitionChild enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95" class="fixed inset-0 flex items-center justify-center p-4">
                <slot />
            </TransitionChild>
        </Dialog>
    </TransitionRoot>
</template>

<script setup lang="ts">
import {
    TransitionRoot,
    TransitionChild,
    Dialog
} from '@headlessui/vue'

</script>