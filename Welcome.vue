<template>
    <div class="min-h-screen bg-gray-50">
        <Head title="Accueil - Trouvez votre bien idéal" />
        
        <!-- Navbar -->
        <PublicNavbar />

        <!-- Hero Section -->
        <section class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 text-white pt-32 pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                        Trouvez votre bien idéal
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-indigo-100">
                        Des milliers de propriétés disponibles à la location
                    </p>
                    
                    <!-- Barre de recherche -->
                    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-2xl p-6">
                        <form @submit.prevent="search" class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <input
                                    v-model="searchForm.query"
                                    type="text"
                                    placeholder="Ville, quartier, adresse..."
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                />
                            </div>
                            <div class="flex-1">
                                <select
                                    v-model="searchForm.type"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                >
                                    <option value="">Tous les types</option>
                                    <option value="appartement">Appartement</option>
                                    <option value="maison">Maison</option>
                                    <option value="bureau">Bureau</option>
                                    <option value="commerce">Commerce</option>
                                    <option value="terrain">Terrain</option>
                                </select>
                            </div>
                            <button
                                type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 whitespace-nowrap"
                            >
                                Rechercher
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Wave decoration -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 80C1200 80 1320 70 1380 65L1440 60V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
                </svg>
            </div>
        </section>

        <!-- Catégories de biens -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Parcourir par catégorie
                    </h2>
                    <p class="text-lg text-gray-600">
                        Trouvez le type de bien qui vous convient
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    <Link
                        href="/biens?type=appartement"
                        class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-center group"
                    >
                        <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-600 transition-colors duration-300">
                            <svg class="w-8 h-8 text-indigo-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Appartements</h3>
                        <p class="text-sm text-gray-600">{{ propertiesCount.appartement || 0 }} biens</p>
                    </Link>

                    <Link
                        href="/biens?type=maison"
                        class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-center group"
                    >
                        <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition-colors duration-300">
                            <svg class="w-8 h-8 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Maisons</h3>
                        <p class="text-sm text-gray-600">{{ propertiesCount.maison || 0 }} biens</p>
                    </Link>

                    <Link
                        href="/biens?type=bureau"
                        class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-center group"
                    >
                        <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 transition-colors duration-300">
                            <svg class="w-8 h-8 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Bureaux</h3>
                        <p class="text-sm text-gray-600">{{ propertiesCount.bureau || 0 }} biens</p>
                    </Link>

                    <Link
                        href="/biens?type=commerce"
                        class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-center group"
                    >
                        <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition-colors duration-300">
                            <svg class="w-8 h-8 text-purple-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Commerces</h3>
                        <p class="text-sm text-gray-600">{{ propertiesCount.commerce || 0 }} biens</p>
                    </Link>

                    <Link
                        href="/biens?type=terrain"
                        class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-center group"
                    >
                        <div class="bg-amber-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:bg-amber-600 transition-colors duration-300">
                            <svg class="w-8 h-8 text-amber-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Terrains</h3>
                        <p class="text-sm text-gray-600">{{ propertiesCount.terrain || 0 }} biens</p>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Biens en vedette -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-12">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                            Biens disponibles
                        </h2>
                        <p class="text-lg text-gray-600">
                            Découvrez nos dernières offres de location
                        </p>
                    </div>
                    <Link
                        href="/biens"
                        class="hidden md:inline-flex items-center text-indigo-600 hover:text-indigo-700 font-semibold"
                    >
                        Voir tout
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </Link>
                </div>

                <!-- Grille des biens -->
                <div v-if="featuredProperties.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        v-for="property in featuredProperties"
                        :key="property.id"
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300"
                    >
                        <Link :href="`/biens/${property.id}`" class="block">
                            <!-- Image -->
                            <div class="relative h-56 bg-gray-200">
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
                                <div class="absolute top-4 right-4">
                                    <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ formatPropertyType(property.type) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Contenu -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1">
                                    {{ property.title }}
                                </h3>
                                <div class="flex items-center text-gray-600 mb-4">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-sm line-clamp-1">{{ property.address }}, {{ property.city }}</span>
                                </div>
                                
                                <!-- Caractéristiques -->
                                <div class="flex items-center space-x-4 mb-4 text-sm text-gray-600">
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
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-2xl font-bold text-indigo-600">
                                            {{ formatCurrency(property.rent_amount) }}
                                        </span>
                                        <span class="text-gray-600">/mois</span>
                                    </div>
                                    <span class="text-indigo-600 hover:text-indigo-700 font-semibold">
                                        Voir détails →
                                    </span>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>

                <!-- Message si pas de biens -->
                <div v-else class="text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun bien disponible</h3>
                    <p class="mt-2 text-gray-600">Revenez bientôt pour découvrir de nouvelles offres.</p>
                </div>

                <!-- Bouton voir tout (mobile) -->
                <div class="mt-8 text-center md:hidden">
                    <Link
                        href="/biens"
                        class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200"
                    >
                        Voir tous les biens
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-16 bg-indigo-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Vous êtes propriétaire ?
                </h2>
                <p class="text-xl text-indigo-100 mb-8">
                    Gérez facilement vos biens et vos contrats de location
                </p>
                <Link
                    href="/register"
                    class="inline-block bg-white text-indigo-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-200"
                >
                    Commencer maintenant
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <PublicFooter />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/Layout/PublicNavbar.vue';
import PublicFooter from '@/Components/Layout/PublicFooter.vue';

const props = defineProps({
    featuredProperties: {
        type: Array,
        default: () => []
    },
    propertiesCount: {
        type: Object,
        default: () => ({})
    }
});

const searchForm = ref({
    query: '',
    type: ''
});

const search = () => {
    const params = {};
    if (searchForm.value.query) params.search = searchForm.value.query;
    if (searchForm.value.type) params.type = searchForm.value.type;
    
    router.get('/biens', params);
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
