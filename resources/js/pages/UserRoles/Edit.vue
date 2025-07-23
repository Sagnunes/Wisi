<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Role, User } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, PropType, ref } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Gestão de Utilizadores', href: '/dashboard' },
    { title: 'Utilizador', href: '/gestao-utilizadores/utilizadores' },
    { title: 'Atribuir Perfil', href: '/dashboard' },
];

const props = defineProps({
    roles: {
        type: Array as PropType<Role[]>,
        required: true,
    },
    user: {
        type: Object as PropType<User>,
        required: true,
    },
});

const roles = ref(
    props.roles.map((role) => ({
        ...role,
        selected: props.user.roles?.some((p) => p.id === role.id),
    })),
);

const form = useForm({
    user_id: props.user.id,
    selectedRoles: roles.value.filter((p) => p.selected).map((p) => p.id),
});

function onToggle(id: number, value: boolean) {
    const permission = roles.value.find((p) => p.id === id);
    if (permission) permission.selected = value;

    if (value) {
        if (!form.selectedRoles.includes(id)) {
            form.selectedRoles.push(id);
        }
    } else {
        form.selectedRoles = form.selectedRoles.filter((pid) => pid !== id);
    }
}

const selectedPermissionsError = computed(() => {
    return (
        form.errors.selectedRoles ||
        Object.entries(form.errors)
            .filter(([key]) => key.startsWith('selectedPermissions.'))
            .map(([, message]) => message)
            .join(', ') ||
        null
    );
});

function clearAllPermissions() {
    roles.value.forEach((role) => {
        role.selected = false;
    });
    form.selectedRoles = [];
}

function submit() {
    form.patch(route('users.roles.update', props.user.id), {
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
    <Head title="Atribuir Perfil" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col space-y-6 px-4 py-6">
            <div class="flex flex-row items-end justify-between gap-4">
                <HeadingSmall
                    title="Atribuição de Perfil ao Utilizador"
                    description="Atribua um perfil ao utilizador para definir os seus níveis de acesso e permissões no sistema."
                />
            </div>
            <form @submit.prevent="submit">
                <fieldset class="flex flex-col space-y-4">
                    <legend class="sr-only">Perfis</legend>
                    <div class="flex flex-row items-end justify-between gap-4">
                        <p class="text-base font-semibold text-foreground">Perfis</p>
                        <InputError class="mt-2" :message="selectedPermissionsError" />
                        <div class="mt-6 flex flex-row items-center justify-center gap-4" v-if="roles.length">
                            <Button type="submit" :disabled="form.processing"> Guardar </Button>
                            <Button
                                variant="outline"
                                type="button"
                                @click="clearAllPermissions"
                                :disabled="form.processing || !form.selectedRoles.length"
                            >
                                Limpar
                            </Button>
                        </div>
                    </div>
                    <div
                        v-if="roles.length"
                        class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 divide-y-0 rounded-md border border-border bg-muted/50 p-4 md:grid-cols-5"
                    >
                        <div
                            v-for="role in roles"
                            :key="role.id"
                            class="flex flex-col justify-between gap-3 rounded-sm border border-border/50 bg-background px-4 py-3"
                        >
                            <div class="space-y-1">
                                <label
                                    :for="`role-${role.id}`"
                                    class="block cursor-pointer text-sm leading-snug font-medium text-foreground"
                                >
                                    {{ role.name }}
                                </label>
                                <p class="text-xs leading-tight text-muted-foreground">
                                    {{ role.description }}
                                </p>
                            </div>
                            <div class="self-end">
                                <Checkbox
                                    :id="`role-${role.id}`"
                                    :model-value="role.selected"
                                    @update:model-value="(val) => onToggle(role.id, val)"
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
