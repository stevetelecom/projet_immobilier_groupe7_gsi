<template>
    <aside class="fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-white shadow-sm overflow-y-auto">
        <nav class="p-4 space-y-2">
            <SidebarLink :href="route('dashboard')" :active="route().current('dashboard')">
                <template #icon>📊</template>
                Tableau de bord
            </SidebarLink>
            
            <SidebarLink v-if="can('view-any-properties')" :href="route('properties.index')" :active="route().current('properties.*')">
                <template #icon>🏠</template>
                Biens Immobiliers
            </SidebarLink>
            
            <SidebarLink v-if="can('view-any-contracts')" :href="route('contracts.index')" :active="route().current('contracts.*')">
                <template #icon>📝</template>
                Contrats
            </SidebarLink>
            
            <SidebarLink v-if="can('view-any-payments')" :href="route('payments.index')" :active="route().current('payments.*')">
                <template #icon>💰</template>
                Paiements
            </SidebarLink>
            
            <SidebarLink :href="route('invoices.index')" :active="route().current('invoices.*')">
                <template #icon>🧾</template>
                Quittances
            </SidebarLink>
            
            <SidebarLink :href="route('maintenance-requests.index')" :active="route().current('maintenance-requests.*')">
                <template #icon>🔧</template>
                Maintenance
            </SidebarLink>
            
            <SidebarLink v-if="can('view-reports')" :href="route('reports.overview')" :active="route().current('reports.*')">
                <template #icon>📈</template>
                Rapports
            </SidebarLink>
            
            <SidebarLink v-if="isAdmin" :href="route('admin.users.index')" :active="route().current('admin.*')">
                <template #icon>👥</template>
                Utilisateurs
            </SidebarLink>
        </nav>
    </aside>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import SidebarLink from '@/Components/Common/SidebarLink.vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
const isAdmin = computed(() => user.value.roles?.includes('admin'));

const can = (permission) => {
    return user.value.permissions?.includes(permission) || isAdmin.value;
};
</script>
