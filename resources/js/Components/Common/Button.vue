<template>
    <button :type="type" :disabled="disabled" :class="buttonClass" class="px-4 py-2 rounded-lg font-medium transition">
        <slot />
    </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: { type: String, default: 'button' },
    variant: { type: String, default: 'primary' },
    disabled: Boolean,
});

const buttonClass = computed(() => {
    const variants = {
        primary: 'bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50',
        secondary: 'bg-gray-200 text-gray-700 hover:bg-gray-300',
        danger: 'bg-red-600 text-white hover:bg-red-700',
    };
    return variants[props.variant];
});
</script>
