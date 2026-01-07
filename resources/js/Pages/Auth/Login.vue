<template>
    <GuestLayout title="Connexion">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">Connexion</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Ou
                        <Link :href="route('register')" class="font-medium text-indigo-600 hover:text-indigo-500">
                            créer un nouveau compte
                        </Link>
                    </p>
                </div>

                <form @submit.prevent="submit" class="bg-white p-8 rounded-lg shadow space-y-6">
                    <div v-if="status" class="p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                        {{ status }}
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            autofocus
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            :class="{ 'border-red-300': form.errors.email }"
                        />
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            :class="{ 'border-red-300': form.errors.password }"
                        />
                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input v-model="form.remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-900">Se souvenir de moi</span>
                        </label>

                        <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-indigo-600 hover:text-indigo-500">
                            Mot de passe oublié ?
                        </Link>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-3 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 disabled:opacity-50 transition"
                    >
                        {{ form.processing ? 'Connexion...' : 'Se connecter' }}
                    </button>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
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
