<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Fund } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { PropType } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Coleção Digital',
        href: '/colecao-digital',
    },
    {
        title: 'Fundos',
        href: '/',
    },
];

defineProps({
    funds: {
        type: Array as PropType<Fund[]>,
        required: true,
    },
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Coleção Digital" />
        <div class="px-4 py-6">
            <div class="flex h-full flex-1 flex-col rounded-xl p-4">
                <div class="relative">
                    <h2 id="collection-heading" class="sr-only">Fundos</h2>
                    <Heading title="Fundos" />
                    <div
                        class="mx-auto grid max-w-md grid-cols-1 space-y-4 gap-y-6 px-4 sm:max-w-7xl sm:grid-cols-3 sm:gap-x-6 sm:gap-y-0 sm:px-6 md:grid-cols-5 lg:gap-x-8 lg:px-8"
                        v-if="funds.length > 0"
                    >
                        <div
                            v-for="fund in funds"
                            :key="fund.name"
                            class="group relative h-96 rounded-lg bg-white shadow-xl sm:aspect-4/5 sm:h-auto"
                        >
                            <div aria-hidden="true" class="absolute inset-0 overflow-hidden rounded-lg">
                                <div
                                    class="absolute inset-0 overflow-hidden group-hover:opacity-75"
                                    v-for="object in fund.digital_objects"
                                    :key="object.id"
                                >
                                    <img
                                        :src="object.image_thumb"
                                        :alt="object.image_name"
                                        class="size-full object-cover"
                                    />
                                </div>
                                <div class="absolute inset-0 bg-linear-to-b from-transparent to-black opacity-50" />
                            </div>
                            <div class="absolute inset-0 flex items-end rounded-lg p-6">
                                <div>
                                    <p aria-hidden="true" class="hidden text-sm text-white md:block">
                                        {{ fund.acronym }}
                                    </p>
                                    <h3 class="mt-1 font-semibold text-white">
                                        <Link
                                            prefetch="hover"
                                            cache-for="30s"
                                            :href="route('funds.show', fund.acronym)"
                                        >
                                            <span class="absolute inset-0" />
                                            {{ fund.name }}
                                        </Link>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span v-else>Sem fundos.</span>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
