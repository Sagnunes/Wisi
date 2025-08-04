<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogOverlay,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import Status from '@/enums/Status';
import { DigitalObject } from '@/types';
import { DialogPortal } from 'reka-ui';
import { PropType } from 'vue';

defineProps({
    resource: { type: Object as PropType<DigitalObject>, required: true },
});

const DESCRIPTIONS_PATH_PATTERN = /(?=\/descriptions)/;
const VIEWER_PATH_SEGMENT = '/viewer';

function createViewerUrl(url: string): string {
    if (!url?.trim()) {
        return '';
    }

    const [baseUrl, path] = url.split(DESCRIPTIONS_PATH_PATTERN);

    if (!path) {
        return '';
    }

    return `${baseUrl}${VIEWER_PATH_SEGMENT}${path}`;
}

function hasWebsiteUrl(websiteUrl: string): boolean {
    return !websiteUrl || websiteUrl.trim() === '';
}
</script>

<template>
    <div class="flex flex-col gap-y-1">
        <Dialog class="lg:max-w-xl">
            <DialogTrigger>
                <Avatar
                    class="group aspect-square h-full w-full rounded-lg border-b-2 bg-gray-100 group-hover:opacity-75"
                    :class="
                        resource.status.id === Status.NO_ASSOCIATION
                            ? 'border-yellow-500'
                            : resource.status.id === Status.UNPUBLISHED
                              ? 'border-destructive'
                              : 'border-success'
                    "
                >
                    <AvatarImage
                        :src="resource.image_thumb"
                        :alt="resource.image_name"
                        loading="lazy"
                        decoding="async"
                        fetchpriority="low"
                        class="object-cover transition-opacity duration-300 ease-out group-hover:opacity-75"
                    />
                    <AvatarFallback
                        class="flex h-full w-full items-center justify-center rounded-none bg-background text-foreground"
                    >
                        Imagem não encontrada
                    </AvatarFallback>
                </Avatar>
            </DialogTrigger>
            <DialogPortal>
                <DialogOverlay class="bg-primary/10">
                    <DialogContent class="md:max-h-[90vh] md:max-w-6xl">
                        <DialogHeader>
                            <DialogTitle>
                                <div class="mt-4 flex items-center justify-between gap-x-3 text-sm">
                                    <div class="flex flex-row items-center gap-x-2">
                                        <div class="font-semibold text-sidebar-primary">
                                            {{ resource.inventory_number }}
                                        </div>
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium">
                                            <Badge
                                                :variant="
                                                    resource.status.id === Status.NO_ASSOCIATION
                                                        ? 'warning'
                                                        : resource.status.id === Status.UNPUBLISHED
                                                          ? 'destructive'
                                                          : 'success'
                                                "
                                                >{{ resource.status.name }}</Badge
                                            >
                                        </span>
                                    </div>
                                    <p class="text-xs text-shadow-muted">
                                        Data de inserção:
                                        <span class="text-muted-foreground">{{ resource.created_at }}</span>
                                    </p>
                                </div>
                            </DialogTitle>
                            <DialogDescription>
                                {{ resource.title }}
                            </DialogDescription>
                        </DialogHeader>
                        <div class="flex min-h-0 w-full flex-1 items-center justify-center">
                            <img
                                :src="resource.image_derivative"
                                :alt="resource.image_name"
                                class="max-h-full max-w-full rounded-lg object-contain"
                            />
                        </div>
                        <DialogFooter
                            class="flexlg:flex-row"
                            :class="!hasWebsiteUrl(resource.website_link) ? 'md:justify-between' : 'justify-end'"
                        >
                            <div
                                class="flex flex-row items-center gap-x-5"
                                v-if="!hasWebsiteUrl(resource.website_link)"
                            >
                                <a
                                    :href="resource.website_link"
                                    class="cursor-pointer text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                    target="_blank"
                                    >Descrição</a
                                >
                                <a
                                    :href="createViewerUrl(resource.website_link)"
                                    class="cursor-pointer text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                    target="_blank"
                                    >Objeto</a
                                >
                            </div>
                            <DialogClose as-child>
                                <Button variant="default">Fechar</Button>
                            </DialogClose>
                        </DialogFooter>
                    </DialogContent>
                </DialogOverlay>
            </DialogPortal>
        </Dialog>
        <div class="flex flex-col items-start justify-evenly gap-y-3">
            <p class="float-end text-muted-foreground italic">{{ resource.inventory_number }}</p>
            <a
                :href="resource.website_link"
                class="text-xs font-medium text-primary/30 hover:text-primary"
                target="_blank"
                v-show="resource.website_link"
                >Descrição</a
            >
        </div>
    </div>
</template>

<style scoped></style>
