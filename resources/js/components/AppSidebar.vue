<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import NavUserManagement from '@/components/NavUserManagement.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import Permission from '@/enums/Permission';
import Role from '@/enums/Role';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutGrid, LibraryBig, SquareTerminal } from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from './AppLogo.vue';

const page = usePage();

const isWatcher = computed(() => {
    return (page.props.auth.user?.roles ?? []).some((role: any) => role.name === Role.WATCHER);
});

const userPermissions = computed(() => {
    const roles = page.props.auth.user?.roles ?? [];
    const allPermissions = roles.flatMap((role: any) => role.permissions ?? []);
    return [...new Set(allPermissions.map((perm: any) => perm.slug))];
});

const filterNavItemsByPermissions = (items: NavItem[], userPermissions: string[], isSuperAdmin: boolean): NavItem[] => {
    return items
        .filter((item) => {
            if (isSuperAdmin) return true;
            if (!item.permissions || item.permissions.length === 0) {
                return true;
            }
            return item.permissions.some((permission) => userPermissions.includes(permission));
        })
        .map((item) => ({
            ...item,
            items: item.items ? filterNavItemsByPermissions(item.items, userPermissions, isSuperAdmin) : undefined,
        }));
};

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Coleção Digital',
        href: '/colecao-digital',
        icon: LibraryBig,
        permissions: [Permission.ACCESS_DIGITAL_COLLECTION],
    },
];

// const footerNavItems: NavItem[] = [
//     {
//         title: 'Github Repo',
//         href: 'https://github.com/laravel/vue-starter-kit',
//         icon: Folder,
//     },
//     {
//         title: 'Documentation',
//         href: 'https://laravel.com/docs/starter-kits#vue',
//         icon: BookOpen,
//     },
// ];

const navUserManagementItems: NavItem[] = [
    {
        title: 'Gestão de Utilizadores',
        href: '#',
        icon: SquareTerminal,
        isActive: false,
        permissions: [Permission.USER_MANAGEMENT],
        items: [
            {
                title: 'Perfis',
                href: '/gestao-utilizadores/perfis',
            },
            {
                title: 'Permissões',
                href: '/gestao-utilizadores/permissoes',
            },
            {
                title: 'Utilizadores',
                href: '/gestao-utilizadores/utilizadores',
            },
        ],
    },
];

const filteredMainNavItems = computed(() =>
    filterNavItemsByPermissions(mainNavItems, userPermissions.value, isWatcher.value),
);

console.log(isWatcher.value);
const filteredNavManagementItems = computed(() =>
    filterNavItemsByPermissions(navUserManagementItems, userPermissions.value, isWatcher.value),
);
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
            <NavMain :items="filteredMainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUserManagement :nav-items="filteredNavManagementItems" />
            <!--            <NavFooter :items="footerNavItems" />-->
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
