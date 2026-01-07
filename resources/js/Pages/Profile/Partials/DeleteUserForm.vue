<template>
    <Card title="Supprimer le compte">
        <p class="text-sm text-gray-600 mb-4">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
        </p>
        <button @click="confirmDeletion" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Supprimer le compte
        </button>
    </Card>
</template>

<script setup>
import Card from '@/Components/Common/Card.vue';

const confirmDeletion = () => {
    if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')) {
        // Logique de suppression
    }
};
</script>
