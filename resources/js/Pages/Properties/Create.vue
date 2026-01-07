<template>
    <AppLayout title="Créer un bien">
        <div class="py-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">Ajouter un bien immobilier</h1>

                <Card>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                                <input v-model="form.title" type="text" required class="input-field" 
                                    placeholder="Ex: Appartement F3 Centre-ville" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea v-model="form.description" required rows="4" class="input-field"
                                    placeholder="Décrivez le bien..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                                <select v-model="form.type" required class="input-field">
                                    <option value="">Sélectionner</option>
                                    <option value="apartment">Appartement</option>
                                    <option value="house">Maison</option>
                                    <option value="villa">Villa</option>
                                    <option value="studio">Studio</option>
                                    <option value="office">Bureau</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prix/mois (FCFA)</label>
                                <input v-model="form.price_per_month" type="number" required class="input-field" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Charges (FCFA)</label>
                                <input v-model="form.charges" type="number" class="input-field" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Surface (m²)</label>
                                <input v-model="form.surface_area" type="number" required class="input-field" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de pièces</label>
                                <input v-model="form.rooms" type="number" required class="input-field" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Chambres</label>
                                <input v-model="form.bedrooms" type="number" required class="input-field" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Salles de bain</label>
                                <input v-model="form.bathrooms" type="number" required class="input-field" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <input v-model="form.address" type="text" required class="input-field" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input v-model="form.city" type="text" required class="input-field" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                                <input v-model="form.postal_code" type="text" class="input-field" />
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <Link :href="route('properties.index')" class="btn-secondary">Annuler</Link>
                            <button type="submit" :disabled="form.processing" class="btn-primary">
                                Créer le bien
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

const form = useForm({
    title: '',
    description: '',
    type: '',
    price_per_month: '',
    charges: 0,
    surface_area: '',
    rooms: '',
    bedrooms: '',
    bathrooms: '',
    address: '',
    city: '',
    postal_code: '',
});

const submit = () => {
    form.post(route('properties.store'));
};
</script>
