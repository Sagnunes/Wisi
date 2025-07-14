<script setup lang="ts">
import { IMAGES } from '@/constants/images';
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img :src="IMAGES.logo.src" :alt="IMAGES.logo.alt" />
</template>
