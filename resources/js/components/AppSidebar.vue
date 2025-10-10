<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpenText, ChartBarBig, ExternalLink, Folder, GraduationCap, LayoutGrid, LibrarySquare, List, MonitorCog, Notebook, School, User, UserPlus, UserRound, UserRoundPlus, Users, UsersRound } from 'lucide-vue-next';
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
        icon: MonitorCog,
        children: [
            { title: 'Configuracion IA', href: '/setting-ia', icon: UsersRound },
            { title: 'Usuarios', href: '#', icon: UsersRound },
            { title: 'Proyectos de aprendizaje', href: '#', icon: LibrarySquare },
            { title: 'Crear usuario', href: '#', icon: UserRoundPlus },
        ]
    },
    {
        title: 'Sección',
        href: '#',
        icon: School,
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
        icon: Users,
        children: [
            { title: 'Lista de profesores', href: '/teacher/index', icon: List, },
            { title: 'Crear profesor', href: '/teacher/create', icon: UserPlus },
        ]
    },
    {
        title: 'Representante',
        href: '#',
        icon: GraduationCap,
        role: ['Administrador'],
        children: [
            { title: 'Lista de Representates', href: '/representative/index', icon: List, role: ['Administrador'] },
            { title: 'Crear Representante', href: '/representative/create', role: ['Administrador'] },
        ]

    },
    {
        title: 'Estudiante',
        href: '#',
        icon: GraduationCap,
        children: [
            { title: 'Lista de Estudiantes', href: '/student/index', icon: List, role: ['Administrador'] },
            { title: 'Crear Estudiantes', href: '/student/create', role: ['Administrador'] },
            { title: 'Estadisticas', href: '/learning-project/notes/', role: ['Profesor'] }
        ]

    },
    {
        title: 'Proyecto de aprendizaje',
        href: '#',
        icon: BookOpenText,
        children: [
            { title: 'Proyectos', href: '/learning-project/index' },
            { title: 'Agregar R.T', href: '/daily-class/create' },
            { title: 'Evaluar R.T', href: '/teacher/evaluate' }
        ]
    },
    {
        title: 'Referentes Teoricos',
        href: '#',
        icon: ChartBarBig,
        children: [
            { title: 'Crear R.T', href: '/daily-class/create' },
            { title: 'Modificar R.T', href: '#' },
            { title: 'Evaluar R.T', href: '/teacher/evaluate' }
        ]
    },
    {
        title: 'Boletas',
        href: '#',
        icon: Notebook,
        children: [
            { title: 'Crear boletas', href: '/tickets/create' },
            { title: 'Buscar boleta', href: '/tickets' },
            { title: 'Evaluar Clase', href: '#' }
        ]
    }
];

const footerNavItems: NavItem[] = [
    {
        title: 'Japeco',
        href: 'https://sigesin.japeco.com/',
        icon: ExternalLink

    }
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
