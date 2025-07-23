<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <iframe
                src="https://forms.office.com/Pages/ResponsePage.aspx?id=HTktEyJKKUW3ooMz7oh0EBYbAJLiaspNhqOtho7Gi61UN0M0Vk41WkNHMVhHSDBPVU03UjU1QVNDTC4u&embed=true"
                frameborder="0"
                marginwidth="0"
                marginheight="0"
                allowfullscreen
                webkitallowfullscreenart
                mozallowfullscreen
                msallowfullscreen
                class="h-full w-full rounded-xl border-none bg-background"
            ></iframe>
        </div>
    </AppLayout>
</template>
