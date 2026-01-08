<template>
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo et nom -->
                <div class="flex items-center">
                    <Link href="/" class="flex items-center space-x-3">
                        <svg class="h-10 w-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="text-2xl font-bold text-gray-900">ImmoBail</span>
                    </Link>
                </div>

                <!-- Menu desktop -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <Link 
                        href="/" 
                        :class="isActive('/') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600'"
                        class="px-3 py-2 text-base font-medium transition-colors duration-200"
                    >
                        Accueil
                    </Link>
                    
                    <Link 
                        href="/biens" 
                        :class="isActive('/biens') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600'"
                        class="px-3 py-2 text-base font-medium transition-colors duration-200"
                    >
                        Biens
                    </Link>
                    
                    <Link 
                        href="/a-propos" 
                        :class="isActive('/a-propos') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600'"
                        class="px-3 py-2 text-base font-medium transition-colors duration-200"
                    >
                        À propos
                    </Link>
                    
                    <Link 
                        href="/contact" 
                        :class="isActive('/contact') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-700 hover:text-indigo-600'"
                        class="px-3 py-2 text-base font-medium transition-colors duration-200"
                    >
                        Contact
                    </Link>
                </div>

                <!-- Boutons connexion/inscription -->
                <div class="hidden md:flex md:items-center md:space-x-4">
                    <Link 
                        v-if="!auth.user"
                        href="/login" 
                        class="text-gray-700 hover:text-indigo-600 px-4 py-2 text-base font-medium transition-colors duration-200"
                    >
                        Connexion
                    </Link>
                    
                    <Link 
                        v-if="!auth.user"
                        href="/register" 
                        class="bg-indigo-600 text-white hover:bg-indigo-700 px-6 py-2 rounded-lg text-base font-medium transition-colors duration-200"
                    >
                        S'inscrire
                    </Link>

                    <Link 
                        v-if="auth.user"
                        href="/dashboard" 
                        class="bg-indigo-600 text-white hover:bg-indigo-700 px-6 py-2 rounded-lg text-base font-medium transition-colors duration-200"
                    >
                        Dashboard
                    </Link>
                </div>

                <!-- Bouton menu mobile -->
                <div class="flex items-center md:hidden">
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="text-gray-700 hover:text-indigo-600 focus:outline-none"
                    >
                        <svg v-if="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu mobile -->
        <div v-show="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <Link 
                    href="/" 
                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md"
                    @click="mobileMenuOpen = false"
                >
                    Accueil
                </Link>
                
                <Link 
                    href="/biens" 
                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md"
                    @click="mobileMenuOpen = false"
                >
                    Biens
                </Link>
                
                <Link 
                    href="/a-propos" 
                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md"
                    @click="mobileMenuOpen = false"
                >
                    À propos
                </Link>
                
                <Link 
                    href="/contact" 
                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md"
                    @click="mobileMenuOpen = false"
                >
                    Contact
                </Link>
                
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <Link 
                        v-if="!auth.user"
                        href="/login" 
                        class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md"
                        @click="mobileMenuOpen = false"
                    >
                        Connexion
                    </Link>
                    
                    <Link 
                        v-if="!auth.user"
                        href="/register" 
                        class="block px-3 py-2 text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md mt-2"
                        @click="mobileMenuOpen = false"
                    >
                        S'inscrire
                    </Link>

                    <Link 
                        v-if="auth.user"
                        href="/dashboard" 
                        class="block px-3 py-2 text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md"
                        @click="mobileMenuOpen = false"
                    >
                        Dashboard
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const auth = computed(() => page.props.auth || {});

const mobileMenuOpen = ref(false);

const isActive = (path) => {
    return window.location.pathname === path;
};
</script>
