<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
        <div class="container mx-auto px-4 py-16">
            <div class="flex justify-between items-center mb-16">
                <h1 class="text-4xl font-bold text-white">🏢 Gestion Location</h1>
                <div class="space-x-4">
                    <Link v-if="canLogin" :href="route('login')" 
                        class="px-6 py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Connexion
                    </Link>
                    <Link v-if="canRegister" :href="route('register')" 
                        class="px-6 py-3 bg-indigo-700 text-white rounded-lg font-semibold hover:bg-indigo-800 transition">
                        Inscription
                    </Link>
                </div>
            </div>

            <div class="text-center text-white mb-20">
                <h2 class="text-5xl font-extrabold mb-6">
                    Gérez vos biens immobiliers en toute simplicité
                </h2>
                <p class="text-xl mb-8 text-indigo-100">
                    Contrats, paiements, maintenance - tout au même endroit
                </p>
                <Link :href="route('register')" 
                    class="inline-block px-8 py-4 bg-white text-indigo-600 rounded-lg text-lg font-bold hover:bg-gray-100 transition shadow-lg">
                    Commencer gratuitement →
                </Link>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 text-white">
                    <div class="text-4xl mb-4">🏠</div>
                    <h3 class="text-xl font-bold mb-3">Gestion des Biens</h3>
                    <p class="text-indigo-100">Enregistrez et gérez tous vos biens immobiliers</p>
                </div>

                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 text-white">
                    <div class="text-4xl mb-4">📝</div>
                    <h3 class="text-xl font-bold mb-3">Contrats Électroniques</h3>
                    <p class="text-indigo-100">Signature électronique et génération PDF automatique</p>
                </div>

                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 text-white">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="text-xl font-bold mb-3">Paiements & Facturation</h3>
                    <p class="text-indigo-100">Génération automatique de quittances</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>
