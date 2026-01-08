<template>
    <div class="min-h-screen bg-gray-50">
        <Head title="À propos" />
        
        <!-- Navbar -->
        <PublicNavbar />

        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white pt-28 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-bold mb-2">À propos d'ImmoBail</h1>
                <p class="text-indigo-100">
                    Votre partenaire de confiance pour la gestion immobilière
                </p>
            </div>
        </div>

        <!-- Contenu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Notre mission -->
            <section class="mb-16">
                <div class="bg-white rounded-lg shadow-md p-8 md:p-12">
                    <div class="max-w-3xl mx-auto text-center">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Notre Mission</h2>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            ImmoBail est une plateforme innovante de gestion de contrats de location de biens immobiliers. 
                            Notre mission est de simplifier et moderniser la gestion locative pour les propriétaires, 
                            les locataires et les agents immobiliers au Cameroun.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Nos valeurs -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Nos Valeurs</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <div class="flex justify-center mb-4">
                            <div class="bg-indigo-100 rounded-full p-4">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Confiance</h3>
                        <p class="text-gray-600">
                            Nous mettons la transparence et la sécurité au cœur de notre plateforme pour garantir 
                            des transactions fiables.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <div class="flex justify-center mb-4">
                            <div class="bg-green-100 rounded-full p-4">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Innovation</h3>
                        <p class="text-gray-600">
                            Nous utilisons les dernières technologies pour offrir une expérience moderne et efficace 
                            à nos utilisateurs.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <div class="flex justify-center mb-4">
                            <div class="bg-blue-100 rounded-full p-4">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Service</h3>
                        <p class="text-gray-600">
                            Nous sommes dédiés à fournir un service client exceptionnel et un support réactif 
                            à tous nos utilisateurs.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Fonctionnalités -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Ce que nous offrons</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Gestion des biens</h3>
                            <p class="mt-2 text-base text-gray-600">
                                Enregistrez et gérez vos propriétés avec photos, documents et toutes les informations nécessaires.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Contrats électroniques</h3>
                            <p class="mt-2 text-base text-gray-600">
                                Créez et signez des contrats de location en ligne avec signature électronique sécurisée.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Suivi des paiements</h3>
                            <p class="mt-2 text-base text-gray-600">
                                Suivez tous les paiements de loyer, générez des quittances automatiquement et recevez des alertes.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Gestion de maintenance</h3>
                            <p class="mt-2 text-base text-gray-600">
                                Gérez les réclamations et demandes de maintenance avec suivi en temps réel.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Notifications automatiques</h3>
                            <p class="mt-2 text-base text-gray-600">
                                Recevez des rappels pour les échéances, renouvellements et toutes les informations importantes.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Rapports et statistiques</h3>
                            <p class="mt-2 text-base text-gray-600">
                                Accédez à des tableaux de bord détaillés et exportez des rapports en PDF ou Excel.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Statistiques -->
            <section class="mb-16">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-lg shadow-xl p-8 md:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                        <div>
                            <div class="text-4xl font-bold text-white mb-2">500+</div>
                            <div class="text-indigo-100">Biens gérés</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-white mb-2">1000+</div>
                            <div class="text-indigo-100">Utilisateurs actifs</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-white mb-2">98%</div>
                            <div class="text-indigo-100">Satisfaction client</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section>
                <div class="bg-white rounded-lg shadow-md p-8 md:p-12 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Prêt à commencer ?
                    </h2>
                    <p class="text-lg text-gray-600 mb-8">
                        Rejoignez ImmoBail aujourd'hui et simplifiez la gestion de vos biens immobiliers
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link
                            href="/register"
                            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200"
                        >
                            Créer un compte
                        </Link>
                        <Link
                            href="/contact"
                            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-900 px-8 py-3 rounded-lg font-semibold transition-colors duration-200"
                        >
                            Nous contacter
                        </Link>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <PublicFooter />
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/Layout/PublicNavbar.vue';
import PublicFooter from '@/Components/Layout/PublicFooter.vue';
</script>
