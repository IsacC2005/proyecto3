<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { computed } from 'vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Administrar',
        href: '#',
        role: ['Administrador'],
        icon: LayoutGrid,
        children: [
            { title: 'Usuarios', href: '#' },
            { title: 'Proyectos de aprendizaje', href: '#' },
            { title: 'Crear usuario', href: '#' },
            { title: 'Crear usuario', href: '#' },
        ]
    },
    {
        title: 'Matriculas',
        href: '#',
        icon: Folder,
        children: [
            { title: 'Lista de matriculas', href: '/enrollment/index', role: ['Administrador'] },
            { title: 'Crear matricula', href: '/enrollment/create', role: ['Administrador'] },
            { title: 'Matriculas Asignadas', href: '/teacher/enrollments-assigns', role: ['Profesor'] }
        ]
    },
    {
        title: 'Profesores',
        href: '#',
        role: ['Administrador'],
        icon: Folder,
        children: [
            { title: 'Lista de profesores', href: '/teacher/index' },
            { title: 'Crear profesor', href: '/teacher/create' },
        ]
    },
    {
        title: 'Estudiante',
        href: '#',
        icon: Folder,
        children: [
            { title: 'Lista de Estudiantes', href: '/student/index', role: ['Administrador'] },
            { title: 'Crear Estudiantes', href: '/student/create', role: ['Administrador'] },
            { title: 'Estadisticas', href: '#', role: ['Profesor'] }
        ]

    },
    {
        title: 'Proyecto de aprendizaje',
        href: '#',
        icon: Folder,
        children: [
            { title: 'Proyectos', href: '/learning-project/index' },
            { title: 'Agregar clase', href: '/daily-class/create' },
            { title: 'Evaluar Clase', href: '/teacher/evaluate' }
        ]
    },
    {
        title: 'Clase',
        href: '#',
        icon: Folder,
        children: [
            { title: 'Crear clase', href: '/daily-class/create' },
            { title: 'Modificar clase', href: '#' },
            { title: 'Evaluar Clase', href: '/teacher/evaluate' }
        ]
    },
    {
        title: 'Boletas',
        href: '#',
        icon: Folder,
        children: [
            { title: 'Crear boletas', href: '#' },
            { title: 'Buscar boleta', href: '#' },
            { title: 'Evaluar Clase', href: '#' }
        ]
    }
];

const footerNavItems: NavItem[] = [
];

const page = usePage();
const user = computed(() => page.props.auth.roles);

const filteredNavItems = computed((): NavItem[] => {
    const isVisible = (item: NavItem) => {
        if (!item.role) {
            return true;
        }

        return item.role.some(role => user.value.includes(role));
    }

    const filterNavItems = (items: NavItem[]): NavItem[] => {
        return items.filter(
            item => {
                const visible = isVisible(item);
                if (item.children) {
                    item.children = filterNavItems(item.children);
                }

                // El elemento es visible si el padre lo es Y (si tiene hijos) tiene al menos un hijo visible
                return visible && (!item.children || item.children.length > 0);
            }
        );
    }
    return filterNavItems(mainNavItems);


});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>

            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="filteredNavItems" />
        </SidebarContent>
        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
