<template>
    <GuestLayout>
        <Head title="Vérification de l'email" />

        <div class="mb-4 text-sm text-gray-600">
            Merci pour votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant 
            sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'e-mail, nous vous en enverrons 
            volontiers un autre.
        </div>

        <div v-if="verificationLinkSent" class="mb-4 font-medium text-sm text-green-600">
            Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de votre inscription.
        </div>

        <form @submit.prevent="submit">
            <div class="flex items-center justify-between">
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Renvoyer l'email de vérification
                </button>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-gray-600 hover:text-gray-900 underline"
                >
                    Se déconnecter
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

const props = defineProps({
    status: {
        type: String,
        default: null,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>
