<template>
    <Link :href="href" :class="linkClass" class="flex items-center px-4 py-3 rounded-lg transition">
        <span class="mr-3 text-xl"><slot name="icon" /></span>
        <span><slot /></span>
    </Link>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const linkClass = computed(() => 
    props.active
        ? 'bg-indigo-50 text-indigo-600 font-medium'
        : 'text-gray-700 hover:bg-gray-50'
);
</script>
