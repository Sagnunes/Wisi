<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gestão de Utilizadores',
        href: '/dashboard',
    },
    {
        title: 'Perfis',
        href: '/gestão-de-utilizadores/perfis',
    },
    {
        title: 'Atribuir Permissões',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Atribuir Permissões" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col space-y-6 px-4 py-6">
            <div class="flex flex-row items-end justify-between gap-4">
                <HeadingSmall
                    title="Gestão de Permissões do Perfil"
                    description="Gerir as permissões associadas a este perfil para controlar o acesso a funcionalidades do sistema."
                />
            </div>
        </div>
    </AppLayout>
</template>
