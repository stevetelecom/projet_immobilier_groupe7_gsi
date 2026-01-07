<template>
    <AppLayout title="Utilisateurs">
        <div class="py-6">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Gestion des Utilisateurs</h1>
                    <Link :href="route('admin.users.create')" class="btn-primary">
                        ➕ Nouvel utilisateur
                    </Link>
                </div>

                <Card>
                    <div class="mb-4">
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Rechercher..."
                            class="input-field max-w-md"
                            @input="handleSearch"
                        />
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôles</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date création</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ user.name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ user.email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span v-for="role in user.roles" :key="role" 
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            {{ role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ user.created_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="route('admin.users.edit', user.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            Modifier
                                        </Link>
                                        <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-900">
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="users.links" class="mt-6" />
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import Card from '@/Components/Common/Card.vue';
import Pagination from '@/Components/Common/Pagination.vue';

defineProps({
    users: Object,
    filters: Object,
});

const search = ref('');

const handleSearch = () => {
    router.get(route('admin.users.index'), { search: search.value }, {
        preserveState: true,
        replace: true,
    });
};

const deleteUser = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        router.delete(route('admin.users.destroy', id));
    }
};
</script>
