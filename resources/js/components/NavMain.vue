<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import SubNavMain from './SubNavMain.vue';

defineProps<{
    items: NavItem[];
}>();

const page = usePage();

const openMenus = ref({});

const toggleSubmenu = (label) => {
    openMenus.value[label] = !openMenus.value[label];
};
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton v-if="item.children" as-child
                    :is-active="item.children.some(child => child.href === page.url)" :tooltip="item.title">
                    <div @click.prevent="toggleSubmenu(item.title)" class="cursor-pointer"
                        :class="{ 'border border-accent': openMenus[item.title] || item.children.some(child => child.href === page.url) }">
                        <component :is="item.icon" />
                        <span class="select-none">{{ item.title }}</span>
                    </div>
                    <SubNavMain v-show="openMenus[item.title] || item.children.some(child => child.href === page.url)"
                        :items="item.children" />
                </SidebarMenuButton>

                <SidebarMenuButton v-else as-child :is-active="item.href === page.url" :tooltip="item.title">
                    <Link :href="item.href">
                    <component :is="item.icon" />
                    <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
