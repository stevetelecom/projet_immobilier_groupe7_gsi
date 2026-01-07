<template>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">{{ title }}</p>
                <p class="text-2xl font-bold mt-2">{{ value }}</p>
            </div>
            <div :class="colorClass" class="text-4xl">{{ icon }}</div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: String,
    value: [String, Number],
    icon: String,
    color: String,
});

const colorClass = computed(() => {
    const colors = {
        blue: 'text-blue-500',
        green: 'text-green-500',
        purple: 'text-purple-500',
        orange: 'text-orange-500',
        red: 'text-red-500',
    };
    return colors[props.color] || 'text-gray-500';
});
</script>
