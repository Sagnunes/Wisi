<script setup lang="ts">
import ObjectCard from '@/components/DigitalCollection/ObjectCard.vue';
import SearchInput from '@/components/DigitalCollection/SearchInput.vue';
import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, DigitalObject, Fund, Pagination } from '@/types';
import { Head, router, WhenVisible } from '@inertiajs/vue3';
import { watchDebounced } from '@vueuse/core';
import { LoaderCircle } from 'lucide-vue-next';
import { computed, PropType, ref } from 'vue';

const props = defineProps({
    fund: { type: Object as PropType<Fund>, required: true },
    collections: { type: Array as PropType<DigitalObject[]>, required: true },
    pagination: { type: Object as PropType<Pagination>, required: true },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Coleção Digital',
        href: '/colecao-digital',
    },
    {
        title: 'Fundos',
        href: '/colecao-digital',
    },
];

breadcrumbs.push({
    title: props.fund?.acronym,
    href: '/',
});

const searchInput = ref('');
const reachedEnd = computed(() => {
    return (props.pagination?.current_page ?? 0) >= (props.pagination?.last_page ?? 0);
});

watchDebounced(
    searchInput,
    (value) => {
        router.get(route('funds.show', props.fund?.acronym), { search: value }, { preserveState: true });
    },
    { debounce: 500 },
);

function onSearchInput(value: string) {
    searchInput.value = value;
}

const heading = computed(() => {
    return `Coleção Digital - ${props.fund.name}`;
});
</script>

<template>
    <Head :title="fund?.acronym" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <div class="flex h-full flex-1 flex-col rounded-xl p-4">
                <div class="relative">
                    <h2 id="collection-heading" class="sr-only">
                        Coleção Digital - {{ fund.name == '' ? fund.acronym : fund.name }}
                    </h2>
                    <Heading :title="heading" />
                    <SearchInput :model-value="searchInput" @update:modelValue="onSearchInput" />
                    <div>
                        <p class="my-3 text-xs text-primary" v-if="pagination.total > 1">
                            Foram encontrados: <span class="font-bold">{{ pagination.total }}</span> objetos digitais.
                        </p>
                        <p class="my-3 text-xs text-primary" v-else>
                            Foi encontrado <span class="font-bold">{{ pagination.total }}</span> objecto digital.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-7 lg:gap-x-8">
                    <div v-for="resource in collections" :key="resource.id" class="group text-sm">
                        <ObjectCard :resource />
                    </div>
                    <WhenVisible
                        :always="!reachedEnd"
                        :params="{
                            only: ['collections', 'pagination'],
                            data: { page: (pagination?.current_page ?? 0) + 1 },
                        }"
                    >
                        <template #fallback>
                            <LoaderCircle></LoaderCircle>
                        </template>
                    </WhenVisible>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
