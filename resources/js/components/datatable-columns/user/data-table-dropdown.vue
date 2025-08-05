<script setup lang="ts">
import Dialog from '@/components/Dialogs/Dialog.vue';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import Status from '@/enums/Status';
import { User } from '@/types';
import { router, useForm } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';

const { user } = defineProps<{ user: User }>();

const form = useForm({
    updatedStatus: 0,
    user_id: user.id,
});

const isDeleteDialogOpen = ref(false);
const isValidatedDialogOpen = ref(false);

const statusActionText = computed(() => {
    switch (user.status.id) {
        case Status.PENDING:
            return 'Validar';
        case Status.ACTIVE:
            return 'Bloquear';
        case Status.BLOCKED:
            return 'Validar';
        default:
            return 'Validar';
    }
});

const statusActionVariant = computed(() => {
    switch (user.status.id) {
        case Status.PENDING:
            return 'success';
        case Status.ACTIVE:
            return 'destructive';
        case Status.BLOCKED:
            return 'success';
        default:
            return 'success';
    }
});

function openValidatedDialog() {
    isValidatedDialogOpen.value = true;
}

function openDeleteDialog() {
    isDeleteDialogOpen.value = true;
}

function submitDelete() {
    form.delete(route('users.destroy', user.id), {
        onSuccess: (response: any) => {
            isDeleteDialogOpen.value = false;
            if (response?.props?.flash?.status) {
                toast.success(response.props.flash.status);
            }
        },
        preserveScroll: true,
        preserveState: true,
    });
}

function submitValidate(status: number) {
    form.updatedStatus = status;
    form.patch(route('users.status.update', user.id), {
        onSuccess: (response: any) => {
            isValidatedDialogOpen.value = false;
            if (response?.props?.flash?.status) {
                toast.success(response.props.flash.status);
            }
        },
        preserveScroll: true,
        preserveState: true,
    });
}

function getCorrectStatus(status: Status): Status {
    switch (status) {
        case Status.PENDING:
            return Status.ACTIVE;
        case Status.ACTIVE:
            return Status.BLOCKED;
        default:
            return Status.ACTIVE;
    }
}

const goToEditUserRolesPage = () => {
    router.get(route('users.roles.edit', user.id));
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="h-8 w-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="h-4 w-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Ações</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="openDeleteDialog">Apagar</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="openValidatedDialog">{{ statusActionText }}</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="goToEditUserRolesPage">Atribuir Perfil</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>

    <Dialog
        v-model="isValidatedDialogOpen"
        title="Validar Utilizador"
        description="Tem certeza que deseja validar o utilizador?"
    >
        <template #submitButton>
            <Button
                type="submit"
                @click="submitValidate(getCorrectStatus(user.status.id))"
                :variant="statusActionVariant"
                >{{ statusActionText }}
            </Button>
        </template>
    </Dialog>

    <Dialog
        v-model="isDeleteDialogOpen"
        title="Eliminar utilizador"
        description="Tem certeza que deseja deseja eliminar o utilizador? Este processo não pode ser desfeito. "
    >
        <template #submitButton>
            <Button type="submit" @click="submitDelete" variant="destructive">Apagar</Button>
        </template>
    </Dialog>
</template>
