<template>
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">
                    🏢 Gestion Location
                </Link>
            </div>
        </header>
        
        <main class="flex-1">
            <slot />
        </main>
        
        <footer class="bg-gray-800 text-white py-6">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; {{ new Date().getFullYear() }} Gestion Location. Tous droits réservés.</p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
