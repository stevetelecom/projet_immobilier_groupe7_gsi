<template>
    <div class="min-h-screen bg-gray-50">
        <Head title="Biens disponibles" />
        
        <!-- Navbar -->
        <PublicNavbar />

        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white pt-28 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-bold mb-2">Biens disponibles</h1>
                <p class="text-indigo-100">
                    {{ properties.total }} bien{{ properties.total > 1 ? 's' : '' }} trouvé{{ properties.total > 1 ? 's' : '' }}
                </p>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar - Filtres -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">Filtres</h2>
                        
                        <form @submit.prevent="applyFilters">
                            <!-- Recherche -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Rechercher
                                </label>
                                <input
                                    v-model="filters.search"
                                    type="text"
                                    placeholder="Ville, quartier..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                />
                            </div>

                            <!-- Type de bien -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Type de bien
                                </label>
                                <select
                                    v-model="filters.type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                >
                                    <option value="">Tous les types</option>
                                    <option value="appartement">Appartement</option>
                                    <option value="maison">Maison</option>
                                    <option value="bureau">Bureau</option>
                                    <option value="commerce">Commerce</option>
                                    <option value="terrain">Terrain</option>
                                </select>
                            </div>

                            <!-- Prix -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Prix maximum (FCFA)
                                </label>
                                <input
                                    v-model="filters.max_price"
                                    type="number"
                                    placeholder="Ex: 500000"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                />
                            </div>

                            <!-- Surface -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Surface minimum (m²)
                                </label>
                                <input
                                    v-model="filters.min_surface"
                                    type="number"
                                    placeholder="Ex: 50"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                />
                            </div>

                            <!-- Nombre de chambres -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Chambres minimum
                                </label>
                                <select
                                    v-model="filters.min_bedrooms"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                >
                                    <option value="">Peu importe</option>
                                    <option value="1">1+</option>
                                    <option value="2">2+</option>
                                    <option value="3">3+</option>
                                    <option value="4">4+</option>
                                </select>
                            </div>

                            <!-- Boutons -->
                            <div class="flex space-x-2">
                                <button
                                    type="submit"
                                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-medium transition-colors duration-200"
                                >
                                    Appliquer
                                </button>
                                <button
                                    type="button"
                                    @click="resetFilters"
                                    class="px-4 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-medium transition-colors duration-200"
                                >
                                    Réinitialiser
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Liste des biens -->
                <div class="lg:col-span-3">
                    <!-- Tri -->
                    <div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="text-sm text-gray-600">
                            Affichage de {{ properties.from || 0 }} à {{ properties.to || 0 }} sur {{ properties.total }} résultats
                        </div>
                        <div class="flex items-center space-x-2">
                            <label class="text-sm text-gray-600">Trier par:</label>
                            <select
                                v-model="filters.sort"
                                @change="applyFilters"
                                class="px-3 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            >
                                <option value="recent">Plus récent</option>
                                <option value="price_asc">Prix croissant</option>
                                <option value="price_desc">Prix décroissant</option>
                                <option value="surface_desc">Surface décroissante</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grille des biens -->
                    <div v-if="properties.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div
                            v-for="property in properties.data"
                            :key="property.id"
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <Link :href="`/biens/${property.id}`">
                                <!-- Image -->
                                <div class="relative h-48 bg-gray-200">
                                    <img
                                        v-if="property.primary_photo"
                                        :src="property.primary_photo"
                                        :alt="property.title"
                                        class="w-full h-full object-cover"
                                    />
                                    <div v-else class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ formatPropertyType(property.type) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Contenu -->
                                <div class="p-5">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">
                                        {{ property.title }}
                                    </h3>
                                    <div class="flex items-center text-gray-600 mb-3">
                                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-sm line-clamp-1">{{ property.city }}</span>
                                    </div>
                                    
                                    <!-- Caractéristiques -->
                                    <div class="flex items-center space-x-4 mb-3 text-xs text-gray-600">
                                        <div v-if="property.surface" class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                            </svg>
                                            {{ property.surface }} m²
                                        </div>
                                        <div v-if="property.rooms" class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                            {{ property.rooms }} pièces
                                        </div>
                                        <div v-if="property.bedrooms" class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                            {{ property.bedrooms }} ch.
                                        </div>
                                    </div>

                                    <!-- Prix -->
                                    <div class="flex items-center justify-between border-t pt-3">
                                        <div>
                                            <span class="text-xl font-bold text-indigo-600">
                                                {{ formatCurrency(property.rent_amount) }}
                                            </span>
                                            <span class="text-sm text-gray-600">/mois</span>
                                        </div>
                                        <span class="text-indigo-600 hover:text-indigo-700 text-sm font-semibold">
                                            Détails →
                                        </span>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>

                    <!-- Message si aucun résultat -->
                    <div v-else class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun bien trouvé</h3>
                        <p class="mt-2 text-gray-600">Essayez de modifier vos critères de recherche.</p>
                        <button
                            @click="resetFilters"
                            class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200"
                        >
                            Réinitialiser les filtres
                        </button>
                    </div>

                    <!-- Pagination -->
                    <div v-if="properties.data.length > 0" class="mt-8">
                        <div class="flex justify-center">
                            <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <Link
                                    v-for="link in properties.links"
                                    :key="link.label"
                                    :href="link.url"
                                    :class="[
                                        'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                        link.active
                                            ? 'z-10 bg-indigo-600 border-indigo-600 text-white'
                                            : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50',
                                        !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                    ]"
                                    v-html="link.label"
                                    :preserve-scroll="true"
                                />
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <PublicFooter />
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/Layout/PublicNavbar.vue';
import PublicFooter from '@/Components/Layout/PublicFooter.vue';

const props = defineProps({
    properties: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        default: () => ({})
    }
});

const filters = ref({
    search: props.filters.search || '',
    type: props.filters.type || '',
    max_price: props.filters.max_price || '',
    min_surface: props.filters.min_surface || '',
    min_bedrooms: props.filters.min_bedrooms || '',
    sort: props.filters.sort || 'recent'
});

const applyFilters = () => {
    const params = {};
    
    if (filters.value.search) params.search = filters.value.search;
    if (filters.value.type) params.type = filters.value.type;
    if (filters.value.max_price) params.max_price = filters.value.max_price;
    if (filters.value.min_surface) params.min_surface = filters.value.min_surface;
    if (filters.value.min_bedrooms) params.min_bedrooms = filters.value.min_bedrooms;
    if (filters.value.sort) params.sort = filters.value.sort;
    
    router.get('/biens', params, { preserveState: true, preserveScroll: true });
};

const resetFilters = () => {
    filters.value = {
        search: '',
        type: '',
        max_price: '',
        min_surface: '',
        min_bedrooms: '',
        sort: 'recent'
    };
    router.get('/biens');
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'XAF',
        minimumFractionDigits: 0
    }).format(amount);
};

const formatPropertyType = (type) => {
    const types = {
        'appartement': 'Appartement',
        'maison': 'Maison',
        'bureau': 'Bureau',
        'commerce': 'Commerce',
        'terrain': 'Terrain'
    };
    return types[type] || type;
};
</script>
