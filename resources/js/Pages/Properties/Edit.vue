<template>
    <AppLayout title="Modifier le bien">
        <div class="py-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">Modifier le bien</h1>

                <Card>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                                <input v-model="form.title" type="text" required class="input-field" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea v-model="form.description" required rows="4" class="input-field"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prix/mois (FCFA)</label>
                                <input v-model="form.price_per_month" type="number" required class="input-field" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Charges (FCFA)</label>
                                <input v-model="form.charges" type="number" class="input-field" />
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <Link :href="route('properties.show', property.id)" class="btn-secondary">Annuler</Link>
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
    property: Object,
});

const form = useForm({
    title: props.property.title,
    description: props.property.description,
    price_per_month: props.property.price_per_month,
    charges: props.property.charges,
});

const submit = () => {
    form.put(route('properties.update', props.property.id));
};
</script>
