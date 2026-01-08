<template>
    <GuestLayout>
        <Head title="Inscription" />

        <form @submit.prevent="submit">
            <!-- Name -->
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Nom complet</label>
                <input
                    id="name"
                    type="text"
                    v-model="form.name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                    autofocus
                    autocomplete="name"
                />
                <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">
                    {{ form.errors.name }}
                </div>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input
                    id="email"
                    type="email"
                    v-model="form.email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">
                    {{ form.errors.email }}
                </div>
            </div>

            <!-- Role -->
            <div class="mt-4">
                <label for="role" class="block font-medium text-sm text-gray-700">Type de compte</label>
                <select
                    id="role"
                    v-model="form.role"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                >
                    <option value="">Sélectionner un rôle</option>
                    <option value="proprietaire">Propriétaire</option>
                    <option value="locataire">Locataire</option>
                    <option value="agent">Agent immobilier</option>
                </select>
                <div v-if="form.errors.role" class="text-red-600 text-sm mt-1">
                    {{ form.errors.role }}
                </div>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700">Mot de passe</label>
                <input
                    id="password"
                    type="password"
                    v-model="form.password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">
                    {{ form.errors.password }}
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">
                    Confirmer le mot de passe
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password_confirmation" class="text-red-600 text-sm mt-1">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="text-sm text-indigo-600 hover:text-indigo-900 underline"
                >
                    Déjà inscrit ?
                </Link>

                <button
                    type="submit"
                    class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    S'inscrire
                </button>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

const form = useForm({
    name: '',
    email: '',
    role: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
