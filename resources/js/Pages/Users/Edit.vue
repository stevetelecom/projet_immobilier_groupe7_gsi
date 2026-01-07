<template>
    <AppLayout title="Modifier un utilisateur">
        <div class="py-6">
            <div class="max-w-2xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">Modifier l'utilisateur</h1>

                <Card>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                            <input v-model="form.name" type="text" required class="input-field" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input v-model="form.email" type="email" required class="input-field" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input v-model="form.phone" type="tel" class="input-field" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                            <select v-model="form.role" required class="input-field">
                                <option v-for="role in roles" :key="role.value" :value="role.value">
                                    {{ role.label }}
                                </option>
                            </select>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <Link :href="route('admin.users.index')" class="btn-secondary">Annuler</Link>
                            <button type="submit" :disabled="form.processing" class="btn-primary">
                                Mettre à jour
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
    user: Object,
    roles: Array,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone,
    role: props.user.roles[0],
});

const submit = () => {
    form.put(route('admin.users.update', props.user.id));
};
</script>
