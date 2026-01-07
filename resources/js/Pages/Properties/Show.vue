<template>
    <AppLayout title="Détails du bien">
        <div class="py-6">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">{{ property.title }}</h1>
                    <div class="flex space-x-3">
                        <Link v-if="can.update" :href="route('properties.edit', property.id)" class="btn-secondary">
                            ✏️ Modifier
                        </Link>
                        <button v-if="can.delete" @click="deleteProperty" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            🗑️ Supprimer
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Galerie photos -->
                        <Card title="Photos">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div v-for="image in property.images" :key="image.id" class="relative">
                                    <img :src="image.url" alt="Property" class="w-full h-40 object-cover rounded-lg" />
                                    <span v-if="image.is_primary" 
                                        class="absolute top-2 left-2 px-2 py-1 bg-indigo-600 text-white text-xs rounded">
                                        Principal
                                    </span>
                                </div>
                            </div>
                        </Card>

                        <!-- Description -->
                        <Card title="Description">
                            <p class="text-gray-700">{{ property.description }}</p>
                        </Card>

                        <!-- Caractéristiques -->
                        <Card title="Caractéristiques">
                            <dl class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm text-gray-500">Type</dt>
                                    <dd class="text-sm font-medium">{{ property.type }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Surface</dt>
                                    <dd class="text-sm font-medium">{{ property.surface_area }} m²</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Pièces</dt>
                                    <dd class="text-sm font-medium">{{ property.rooms }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Chambres</dt>
                                    <dd class="text-sm font-medium">{{ property.bedrooms }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Salles de bain</dt>
                                    <dd class="text-sm font-medium">{{ property.bathrooms }}</dd>
                                </div>
                            </dl>
                        </Card>
                    </div>

                    <div class="space-y-6">
                        <!-- Infos principales -->
                        <Card>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-indigo-600 mb-2">
                                    {{ formatCurrency(property.price_per_month) }}/mois
                                </p>
                                <span :class="statusClass(property.status)" 
                                    class="px-3 py-1 rounded-full text-sm font-medium">
                                    {{ property.status }}
                                </span>
                            </div>

                            <div class="mt-6 space-y-3">
                                <div class="flex items-center text-sm">
                                    <span class="text-gray-500 w-24">Localisation:</span>
                                    <span class="font-medium">{{ property.city }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <span class="text-gray-500 w-24">Adresse:</span>
                                    <span class="font-medium">{{ property.address }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <span class="text-gray-500 w-24">Propriétaire:</span>
                                    <span class="font-medium">{{ property.owner.name }}</span>
                                </div>
                            </div>
                        </Card>

                        <!-- Actions -->
                        <Card title="Actions rapides">
                            <div class="space-y-2">
                                <Link :href="route('contracts.create', { property_id: property.id })" 
                                    class="block w-full text-center btn-primary">
                                    📝 Créer un contrat
                                </Link>
                                <button class="w-full btn-secondary">
                                    📊 Voir l'historique
                                </button>
                            </div>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Card from '@/Components/Common/Card.vue';

const props = defineProps({
    property: Object,
    can: Object,
});

const statusClass = (status) => {
    const classes = {
        available: 'bg-green-100 text-green-800',
        rented: 'bg-blue-100 text-blue-800',
        maintenance: 'bg-orange-100 text-orange-800',
    };
    return classes[status];
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('fr-FR').format(amount) + ' FCFA';
};

const deleteProperty = () => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce bien ?')) {
        router.delete(route('properties.destroy', props.property.id));
    }
};
</script>
