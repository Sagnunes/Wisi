<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Permission } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const { shelve } = defineProps<{
    shelve: Permission;
}>();

const form = useForm({
    name: shelve.name,
    description: shelve.description,
});

const breadcrumbs = ref<BreadcrumbItem[]>([
    {
        title: 'Gestão de Utilizadores',
        href: '/dashboard',
    },
    {
        title: 'Prateleiras',
        href: '/gestao-depositos/prateleiras',
    },
]);

breadcrumbs.value.push({
    title: shelve.name,
    href: `/gestao-de-utilizadores/permissoes/${shelve.id}/editar`,
});

const submit = () => {
    form.patch(route('shelves.update', shelve.id), {
        preserveScroll: true,
        onSuccess: () => {
            breadcrumbs.value = [
                ...breadcrumbs.value.slice(0, -1),
                {
                    title: shelve.name,
                    href: `/gestao-deppositos/prateleiras/${shelve.id}/editar`,
                },
            ];
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col space-y-6 px-4 py-6">
            <div class="flex flex-row items-end justify-between gap-4">
                <HeadingSmall title="Editar Prateleira" description="Altere os detalhes da prateleira." />
            </div>
            <div class="grid grid-flow-row-dense grid-cols-2 grid-rows-3">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="name">Nome</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Guardar</Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Guardado.</p>
                        </Transition>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
