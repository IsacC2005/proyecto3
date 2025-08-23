import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    children?: Array;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Enrollment {
    id: number;
    schoole_year: string;
    schoole_moment: number;
    degree: number;
    section: string;
    classroom: number,
    teacher: Teacher,
    learning_project?: {
        id: number;
        title: string;
    };
}

export interface Teacher {
    id: number;
    name: string;
    surname: string;
    email: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
