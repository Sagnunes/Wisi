<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Permission, Role } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, type PropType, ref } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Gestão de Utilizadores', href: '/dashboard' },
    { title: 'Perfis', href: '/gestao-utilizadores/perfis' },
    { title: 'Atribuir Permissões', href: '/dashboard' },
];

const props = defineProps({
    permissions: {
        type: Array as PropType<Permission[]>,
        required: true,
    },
    role: {
        type: Object as PropType<Role>,
        required: true,
    },
});

const permissions = ref(
    props.permissions.map((permission) => ({
        ...permission,
        selected: props.role.permissions?.some((p) => p.id === permission.id),
    })),
);

const form = useForm({
    selectedPermissions: permissions.value.filter((p) => p.selected).map((p) => p.id),
});

function onToggle(id: number, value: boolean) {
    const permission = permissions.value.find((p) => p.id === id);
    if (permission) permission.selected = value;

    if (value) {
        if (!form.selectedPermissions.includes(id)) {
            form.selectedPermissions.push(id);
        }
    } else {
        form.selectedPermissions = form.selectedPermissions.filter((pid) => pid !== id);
    }
}

const selectedPermissionsError = computed(() => {
    return (
        form.errors.selectedPermissions ||
        Object.entries(form.errors)
            .filter(([key]) => key.startsWith('selectedPermissions.'))
            .map(([, message]) => message)
            .join(', ') ||
        null
    );
});

function clearAllPermissions() {
    permissions.value.forEach((permission) => {
        permission.selected = false;
    });
    form.selectedPermissions = [];
}

function submit() {
    form.patch(route('roles.permissions.update', props.role.id), {
        preserveScroll: true,
        onSuccess: (e: object) => {
            const flash = e.props.flash;
            form.reset();
            toast.success(flash.status);
        },
    });
}
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
            <form @submit.prevent="submit">
                <fieldset class="flex flex-col space-y-4">
                    <legend class="sr-only">Permissões</legend>
                    <div class="flex flex-row items-end justify-between gap-4">
                        <p class="text-base font-semibold text-foreground">Permissões</p>
                        <InputError class="mt-2" :message="selectedPermissionsError" />
                        <div class="mt-6 flex flex-row items-center justify-center gap-4" v-if="permissions.length">
                            <Button type="submit" :disabled="form.processing"> Guardar </Button>
                            <Button
                                variant="outline"
                                type="button"
                                @click="clearAllPermissions"
                                :disabled="form.processing || !form.selectedPermissions.length"
                            >
                                Limpar
                            </Button>
                        </div>
                    </div>
                    <div
                        v-if="permissions.length"
                        class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 divide-y-0 rounded-md border border-border bg-muted/50 p-4 md:grid-cols-5"
                    >
                        <div
                            v-for="permission in permissions"
                            :key="permission.id"
                            class="flex flex-col justify-between gap-3 rounded-sm border border-border/50 bg-background px-4 py-3"
                        >
                            <div class="space-y-1">
                                <label
                                    :for="`permission-${permission.id}`"
                                    class="block cursor-pointer text-sm leading-snug font-medium text-foreground"
                                >
                                    {{ permission.name }}
                                </label>
                                <p class="text-xs leading-tight text-muted-foreground">
                                    {{ permission.description }}
                                </p>
                            </div>
                            <div class="self-end">
                                <Checkbox
                                    :id="`permission-${permission.id}`"
                                    :model-value="permission.selected"
                                    @update:model-value="(val) => onToggle(permission.id, val)"
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        v-else
                        class="mt-4 flex items-center justify-center rounded border border-dashed border-border bg-muted/40 p-6 text-sm text-muted-foreground"
                    >
                        Sem permissões criadas.
                    </div>
                </fieldset>
            </form>
        </div>
    </AppLayout>
</template>
