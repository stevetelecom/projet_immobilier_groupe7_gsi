<template>
    <GuestLayout title="Vérification email">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <div class="bg-white p-8 rounded-lg shadow text-center">
                    <div class="text-6xl mb-4">📧</div>
                    <h2 class="text-2xl font-bold mb-4">Vérifiez votre email</h2>
                    
                    <p class="text-gray-600 mb-6">
                        Un lien de vérification a été envoyé à votre adresse email.
                    </p>

                    <div v-if="status === 'verification-link-sent'" 
                        class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                        Un nouveau lien a été envoyé.
                    </div>

                    <form @submit.prevent="submit">
                        <button type="submit" :disabled="form.processing" class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50">
                            Renvoyer l'email
                        </button>
                    </form>

                    <Link :href="route('logout')" method="post" as="button" class="mt-4 text-sm text-gray-600 hover:text-gray-900">
                        Se déconnecter
                    </Link>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

defineProps({ status: String });

const form = useForm({});
const submit = () => form.post(route('verification.send'));
</script>
