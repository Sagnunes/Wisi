<script setup lang="ts">
import { permissionColumns } from '@/components/datatable-columns/permission/columns';
import DataTable from '@/components/DataTable.vue';
import Dialog from '@/components/Dialogs/Dialog.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Permission } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { PropType, ref } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gestão de Utilizadores',
        href: '/dashboard',
    },
    {
        title: 'Permissões',
        href: '/gestao-de-utilizadores/permissoes',
    },
];

defineProps({
    permissions: {
        required: true,
        type: Object as PropType<Permission[]>,
    },
    can: {
        type: Object as PropType<any>,
    },
});

const form = useForm({
    name: '',
    description: '',
});

const closeModal = () => {
    form.reset();
    isOpen.value = false;
};

const isOpen = ref(false);

function openDialog() {
    isOpen.value = true;
}

const submit = () => {
    form.post(route('permissions.store'), {
        onSuccess: (e: object) => {
            const flash = e.props.flash;
            closeModal();
            toast.success(flash.status, {
                action: {
                    label: 'Desfazer',
                    onClick: () => {
                        form.delete(route('permissions.destroy', flash.data.id), {
                            onSuccess: (e: object) => {
                                toast.success(e.props.flash.status);
                            },
                            preserveScroll: true,
                            preserveState: true,
                        });
                    },
                },
            });
        },
        preserveScroll: true,
    });
};
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
                <DataTable :columns="permissionColumns" :data="permissions">
                    <template #createDialog>
                        <Dialog
                            v-model="isOpen"
                            title="Criar uma nova permissão"
                            description="Defina os detalhes da nova permissão para gerir o acesso dos utilizadores a funcionalidades do sistema."
                        >
                            <template #trigger>
                                <Button @click="openDialog">Novo</Button>
                            </template>

                            <div class="grid gap-2">
                                <Label for="name">Nome</Label>
                                <Input id="name" class="mt-1 block w-full" v-model="form.name" required />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="description">Descrição</Label>
                                <Input id="description" class="mt-1 block w-full" v-model="form.description" />
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <template #submitButton>
                                <Button type="submit" @click="submit">Guardar</Button>
                            </template>
                        </Dialog>
                    </template>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>
