<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Role } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    role: Role;
}>();

const { role } = props;

const form = useForm({
    name: role.name,
    description: role.description,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gestão de Utilizadores',
        href: '/dashboard',
    },
    {
        title: 'Perfis',
        href: '/gestao-utilizadores/perfis',
    },
];

breadcrumbs.push({
    title: role.name,
    href: `/gestao-de-utilizadores/perfis/${role.id}/editar`,
});

const submit = () => {
    form.patch(route('roles.update', role.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col space-y-6 px-4 py-6">
            <div class="flex flex-row items-end justify-between gap-4">
                <HeadingSmall
                    title="Editar Perfil"
                    description="Altere as informações do perfil, como o nome e a descrição, conforme necessário."
                />
            </div>
            <div class="grid grid-flow-row-dense grid-cols-2 grid-rows-3">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="name">Nome</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="name">Descrição</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.description" />
                        <InputError class="mt-2" :message="form.errors.description" />
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
