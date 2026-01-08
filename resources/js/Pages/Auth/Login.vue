<template>
    <GuestLayout>
        <Head title="Connexion" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <!-- Email Address -->
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

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700">Mot de passe</label>
                <input
                    id="password"
                    type="password"
                    v-model="form.password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                    autocomplete="current-password"
                />
                <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">
                    {{ form.errors.password }}
                </div>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        v-model="form.remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    />
                    <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-indigo-600 hover:text-indigo-900 underline"
                >
                    Mot de passe oublié ?
                </Link>

                <button
                    type="submit"
                    class="ml-auto inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Se connecter
                </button>
            </div>

            <div class="mt-4 text-center">
                <span class="text-sm text-gray-600">Vous n'avez pas de compte ?</span>
                <Link :href="route('register')" class="ml-1 text-sm text-indigo-600 hover:text-indigo-900 underline">
                    S'inscrire
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
        default: true,
    },
    status: {
        type: String,
        default: null,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
