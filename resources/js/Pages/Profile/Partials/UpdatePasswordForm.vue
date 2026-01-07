<template>
    <Card title="Modifier le mot de passe">
        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                <input v-model="form.current_password" type="password" required class="input-field" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                <input v-model="form.password" type="password" required class="input-field" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                <input v-model="form.password_confirmation" type="password" required class="input-field" />
            </div>

            <button type="submit" :disabled="form.processing" class="btn-primary">
                Mettre à jour
            </button>
        </form>
    </Card>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Card from '@/Components/Common/Card.vue';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('password.update'), {
        onSuccess: () => form.reset(),
    });
};
</script>
