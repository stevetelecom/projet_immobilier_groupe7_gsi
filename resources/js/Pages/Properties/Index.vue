<template>
    <AppLayout title="Biens Immobiliers">
        <div class="py-6">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Mes Biens Immobiliers</h1>
                    <Link :href="route('properties.create')" class="btn-primary">
                        ➕ Nouveau bien
                    </Link>
                </div>

                <Card>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <input
                            v-model="filters.search"
                            type="text"
                            placeholder="Rechercher..."
                            class="input-field"
                            @input="handleFilter"
                        />
                        <select v-model="filters.type" class="input-field" @change="handleFilter">
                            <option value="">Tous les types</option>
                            <option value="apartment">Appartement</option>
                            <option value="house">Maison</option>
                            <option value="villa">Villa</option>
                            <option value="studio">Studio</option>
                        </select>
                        <select v-model="filters.status" class="input-field" @change="handleFilter">
                            <option value="">Tous les statuts</option>
                            <option value="available">Disponible</option>
                            <option value="rented">Loué</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="property in properties.data" :key="property.id" 
                            class="bg-white border rounded-lg overflow-hidden hover:shadow-lg transition">
                            <img :src="property.primary_image || '/images/placeholder.jpg'" 
                                alt="property.title" 
                                class="w-full h-48 object-cover"
                            />
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-lg">{{ property.title }}</h3>
                                    <span :class="statusClass(property.status)" 
                                        class="px-2 py-1 text-xs rounded-full">
                                        {{ property.status }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-2">📍 {{ property.address }}</p>
                                <p class="text-gray-600 text-sm mb-3">{{ property.type }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-indigo-600">
                                        {{ formatCurrency(property.price_per_month) }}
                                    </span>
                                    <Link :href="route('properties.show', property.id)" 
                                        class="text-indigo-600 hover:text-indigo-800">
                                        Voir détails →
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <Pagination :links="properties.links" class="mt-6" />
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Card from '@/Components/Common/Card.vue';
import Pagination from '@/Components/Common/Pagination.vue';

defineProps({
    properties: Object,
});

const filters = reactive({
    search: '',
    type: '',
    status: '',
});

const handleFilter = () => {
    router.get(route('properties.index'), filters, {
        preserveState: true,
        replace: true,
    });
};

const statusClass = (status) => {
    const classes = {
        available: 'bg-green-100 text-green-800',
        rented: 'bg-blue-100 text-blue-800',
        maintenance: 'bg-orange-100 text-orange-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('fr-FR').format(amount) + ' FCFA';
};
</script>
