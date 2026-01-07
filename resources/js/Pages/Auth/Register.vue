<template>
    <GuestLayout title="Inscription">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">Créer un compte</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Ou
                        <Link :href="route('login')" class="font-medium text-indigo-600 hover:text-indigo-500">
                            se connecter
                        </Link>
                    </p>
                </div>

                <form @submit.prevent="submit" class="bg-white p-8 rounded-lg shadow space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
                            :class="{ 'border-red-300': form.errors.name }"
                        />
                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
                            :class="{ 'border-red-300': form.errors.email }"
                        />
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <input
                            v-model="form.password"
                            type="password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
                            :class="{ 'border-red-300': form.errors.password }"
                        />
                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-3 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Inscription...' : "S'inscrire" }}
                    </button>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
