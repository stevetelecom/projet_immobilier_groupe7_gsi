<template>
    <GuestLayout title="Réinitialisation">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <h2 class="text-center text-3xl font-extrabold text-gray-900 mb-8">Nouveau mot de passe</h2>

                <form @submit.prevent="submit" class="bg-white p-8 rounded-lg shadow space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input v-model="form.email" type="email" required class="w-full px-3 py-2 border rounded-md" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                        <input v-model="form.password" type="password" required class="w-full px-3 py-2 border rounded-md" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer</label>
                        <input v-model="form.password_confirmation" type="password" required class="w-full px-3 py-2 border rounded-md" />
                    </div>

                    <button type="submit" :disabled="form.processing" class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50">
                        Réinitialiser
                    </button>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

const props = defineProps({ email: String, token: String });

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => form.post(route('password.store'));
</script>
