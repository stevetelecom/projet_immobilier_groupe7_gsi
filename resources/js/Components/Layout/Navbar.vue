<template>
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <button @click="toggleSidebar" class="lg:hidden mr-4 text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <Link :href="route('dashboard')" class="text-xl font-bold text-indigo-600">
                        🏢 Gestion Location
                    </Link>
                </div>
                
                <div class="flex items-center space-x-4">
                    <NotificationBell />
                    
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                <span>{{ $page.props.auth.user.name }}</span>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </template>
                        
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">Profil</DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">Déconnexion</DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Common/Dropdown.vue';
import DropdownLink from '@/Components/Common/DropdownLink.vue';
import NotificationBell from '@/Components/Notifications/NotificationBell.vue';

const toggleSidebar = () => {
    // Logique toggle sidebar
};
</script>
