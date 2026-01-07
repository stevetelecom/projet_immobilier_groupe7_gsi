<template>
    <Link :href="href" :method="method" :as="as" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        <slot />
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    method: { type: String, default: 'get' },
    as: { type: String, default: 'a' },
});
</script>
