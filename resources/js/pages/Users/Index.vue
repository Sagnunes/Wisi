<script setup lang="ts">
import { userColumns } from '@/components/datatable-columns/user/columns';
import DataTable from '@/components/DataTable.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, User } from '@/types';
import { Head } from '@inertiajs/vue3';
import { PropType } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gestão de Utilizadores',
        href: '/dashboard',
    },
    {
        title: 'Utilizadores',
        href: '/gestao-de-utilizadores/utilizadores',
    },
];

defineProps({
    users: {
        required: true,
        type: Object as PropType<User[]>,
    },
});
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col space-y-6 px-4 py-6">
            <div class="flex flex-row items-end justify-between gap-4">
                <HeadingSmall
                    title="Permissões"
                    description="Gerir e controlar os níveis de acesso dos utilizadores às funcionalidades do sistema."
                />
            </div>
            <div class="flex h-full flex-1 flex-col gap-4 rounded-xl">
                <DataTable :columns="userColumns" :data="users"> </DataTable>
            </div>
        </div>
    </AppLayout>
</template>
