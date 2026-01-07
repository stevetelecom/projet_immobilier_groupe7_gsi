<template>
    <AppLayout title="Créer un utilisateur">
        <div class="py-6">
            <div class="max-w-2xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">Créer un utilisateur</h1>

                <Card>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                            <input v-model="form.name" type="text" required class="input-field" />
                            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input v-model="form.email" type="email" required class="input-field" />
                            <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input v-model="form.phone" type="tel" class="input-field" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                            <input v-model="form.password" type="password" required class="input-field" />
                            <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <input v-model="form.password_confirmation" type="password" required class="input-field" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                            <select v-model="form.role" required class="input-field">
                                <option value="">Sélectionner un rôle</option>
                                <option v-for="role in roles" :key="role.value" :value="role.value">
                                    {{ role.label }}
                                </option>
                            </select>
                            <p v-if="form.errors.role" class="mt-1 text-sm text-red-600">{{ form.errors.role }}</p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <Link :href="route('admin.users.index')" class="btn-secondary">
                                Annuler
                            </Link>
                            <button type="submit" :disabled="form.processing" class="btn-primary">
                                Créer l'utilisateur
                            </button>
                        </div>
                    </form>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Card from '@/Components/Common/Card.vue';

const props = defineProps({
    roles: Array,
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    role: '',
});

const submit = () => {
    form.post(route('admin.users.store'));
};
</script>
