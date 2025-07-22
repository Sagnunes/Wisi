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
import { User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';

const { user } = defineProps<{ user: User }>();

const form = useForm({});

function copy(id: number) {
    navigator.clipboard.writeText(id.toString());
}

const isOpen = ref(false);

function openDialog() {
    isOpen.value = true;
}

function submitDelete() {
    form.delete(route('roles.destroy', user.id), {
        onSuccess: (e: object) => {
            isOpen.value = false;
            toast.success(e.props.flash.status);
        },
        preserveScroll: true,
        preserveState: true,
    });
}
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
            <DropdownMenuItem @click="copy(user.id)"> Copiar ID</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="openDialog">Apagar</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem>Atribuir Perfil</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>

    <Dialog
        v-model="isOpen"
        title="Eliminar utilizador"
        description="Tem certeza que deseja deseja eliminar o utilizador? Este processo não pode ser desfeito. "
    >
        <template #submitButton>
            <Button type="submit" @click="submitDelete" variant="destructive">Apagar</Button>
        </template>
    </Dialog>
</template>
