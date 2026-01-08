<template>
    <GuestLayout>
        <Head title="Mot de passe oublié" />

        <div class="mb-4 text-sm text-gray-600">
            Vous avez oublié votre mot de passe ? Aucun problème. Indiquez-nous simplement votre adresse e-mail et 
            nous vous enverrons par e-mail un lien de réinitialisation de mot de passe qui vous permettra d'en choisir un nouveau.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input
                    id="email"
                    type="email"
                    v-model="form.email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                    autofocus
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link
                    :href="route('login')"
                    class="text-sm text-indigo-600 hover:text-indigo-900 underline"
                >
                    Retour à la connexion
                </Link>

                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Envoyer le lien
                </button>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

defineProps({
    status: {
        type: String,
        default: null,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>
