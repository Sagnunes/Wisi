<template>
    <div class="flex flex-col items-end gap-y-2 pb-6">
        <div
            class="flex rounded-md bg-white outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-primary"
        >
            <input
                type="text"
                name="search"
                id="search"
                class="block min-w-0 grow px-3 py-1.5 text-base text-primary/80 placeholder:text-gray-400 focus:outline-none sm:text-sm/6 dark:text-black"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target?.value)"
                placeholder="Pesquisar"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps({
    modelValue: {
        type: String,
        required: true,
    },
});

defineEmits(['update:modelValue']);
</script>
