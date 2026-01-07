<template>
    <AppLayout title="Détails utilisateur">
        <div class="py-6">
            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Détails de l'utilisateur</h1>
                    <Link :href="route('admin.users.edit', user.id)" class="btn-primary">
                        Modifier
                    </Link>
                </div>

                <div class="grid gap-6">
                    <Card title="Informations personnelles">
                        <dl class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ user.name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ user.email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ user.phone || 'Non renseigné' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Rôles</dt>
                                <dd class="mt-1">
                                    <span v-for="role in user.roles" :key="role" 
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        {{ role }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </Card>

                    <Card title="Statistiques">
                        <dl class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Biens</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ user.properties_count }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Contrats</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ user.contracts_count }}</dd>
                            </div>
                        </dl>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Card from '@/Components/Common/Card.vue';

defineProps({
    user: Object,
});
</script>
