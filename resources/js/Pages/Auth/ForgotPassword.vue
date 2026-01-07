<template>
    <GuestLayout title="Mot de passe oublié">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">Mot de passe oublié ?</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Entrez votre email pour recevoir un lien de réinitialisation
                    </p>
                </div>

                <form @submit.prevent="submit" class="bg-white p-8 rounded-lg shadow space-y-6">
                    <div v-if="status" class="p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                        {{ status }}
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md"
                        />
                    </div>

                    <div class="flex items-center justify-between">
                        <Link :href="route('login')" class="text-sm text-indigo-600 hover:text-indigo-500">
                            ← Retour
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50"
                        >
                            Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

defineProps({ status: String });

const form = useForm({ email: '' });
const submit = () => form.post(route('password.email'));
</script>
