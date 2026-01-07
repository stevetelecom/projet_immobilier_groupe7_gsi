<template>
    <Card title="Informations du profil">
        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                <input v-model="form.name" type="text" required class="input-field" />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input v-model="form.email" type="email" required class="input-field" />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <button type="submit" :disabled="form.processing" class="btn-primary">
                Enregistrer
            </button>
        </form>
    </Card>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import Card from '@/Components/Common/Card.vue';

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const submit = () => {
    form.patch(route('profile.update'));
};
</script>
