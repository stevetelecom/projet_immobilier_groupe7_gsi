<template>
    <nav class="flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            <Link v-if="links[0].url" :href="links[0].url" class="btn-secondary">Précédent</Link>
            <Link v-if="links[links.length - 1].url" :href="links[links.length - 1].url" class="btn-secondary">Suivant</Link>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div class="flex space-x-1">
                <Link v-for="(link, index) in links" :key="index" 
                    :href="link.url"
                    v-html="link.label"
                    :class="link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700'"
                    class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50"
                />
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array,
});
</script>
