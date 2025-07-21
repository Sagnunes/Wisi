<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

defineProps<{
    modelValue: boolean;
    title: string;
    description: string;
}>();

const emit = defineEmits(['update:modelValue']);

const handleOpenChange = (val: boolean) => {
    emit('update:modelValue', val);
};
</script>

<template>
    <Dialog :open="modelValue" @update:open="handleOpenChange">
        <DialogTrigger as-child>
            <slot name="trigger" />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
                <DialogDescription>{{ description }}</DialogDescription>
            </DialogHeader>
            <slot></slot>
            <DialogFooter>
                <slot name="submitButton" />
                <DialogClose as-child>
                    <Button variant="link">Cancelar</Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
