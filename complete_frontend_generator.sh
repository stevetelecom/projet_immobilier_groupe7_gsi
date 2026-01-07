#!/bin/bash
# ==========================================
# GÉNÉRATEUR FRONTEND COMPLET
# Vue 3 + Inertia + Tailwind
# Gestion de Location - Laravel 11
# ==========================================

cat << 'BANNER'
╔═══════════════════════════════════════════════╗
║   🎨 GÉNÉRATEUR FRONTEND COMPLET 🎨          ║
║   Vue 3 + Inertia + Tailwind CSS             ║
║   Application de Gestion de Location         ║
╚═══════════════════════════════════════════════╝
BANNER

echo ""
read -p "📁 Chemin vers votre projet Laravel: " PROJECT_PATH

if [ ! -f "$PROJECT_PATH/artisan" ]; then
    echo "❌ Projet Laravel non trouvé à cet emplacement"
    exit 1
fi

echo ""
echo "✅ Projet Laravel détecté"
echo "🚀 Génération de tous les fichiers frontend..."
echo ""

JS="$PROJECT_PATH/resources/js"
CSS="$PROJECT_PATH/resources/css"

# Créer toute la structure
mkdir -p "$JS"/{Pages/{Auth,Profile/Partials,Users,Properties/Partials,Contracts/Partials,Payments/Partials,Invoices,Maintenance/Partials,Reports,Notifications},Components/{Layout,Common,Charts,Properties,Contracts,Payments,Maintenance,Notifications},Composables,Stores,Utils,Plugins}

# ==========================================
# 1. FICHIERS DE BASE (resources/js)
# ==========================================

cat > "$JS/app.js" << 'EOF'
import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createPinia } from 'pinia';

const appName = import.meta.env.VITE_APP_NAME || 'Gestion Location';
const pinia = createPinia();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: '#4F46E5',
        showSpinner: true,
    },
});
EOF

cat > "$JS/bootstrap.js" << 'EOF'
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
EOF

cat > "$JS/ssr.js" << 'EOF'
import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createSSRApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = import.meta.env.VITE_APP_NAME || 'Gestion Location';

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
        resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
        setup({ App, props, plugin }) {
            return createSSRApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                });
        },
    })
);
EOF

echo "✓ Fichiers de base créés (app.js, bootstrap.js, ssr.js)"

# ==========================================
# 2. CSS DE BASE
# ==========================================

mkdir -p "$CSS"

cat > "$CSS/app.css" << 'EOF'
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
    body {
        @apply bg-gray-50 text-gray-900;
    }
}

@layer components {
    .btn-primary {
        @apply px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition;
    }
    
    .btn-secondary {
        @apply px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition;
    }
    
    .input-field {
        @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent;
    }
    
    .card {
        @apply bg-white rounded-lg shadow-sm p-6;
    }
}
EOF

echo "✓ CSS Tailwind configuré"

# ==========================================
# 3. LAYOUTS
# ==========================================

cat > "$JS/Components/Layout/AppLayout.vue" << 'EOF'
<template>
    <div class="min-h-screen bg-gray-50">
        <Navbar />
        
        <div class="flex">
            <Sidebar v-if="!isMobile" />
            
            <main class="flex-1 p-6 lg:ml-64">
                <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ $page.props.flash.success }}
                </div>
                
                <div v-if="$page.props.flash?.error" class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                    {{ $page.props.flash.error }}
                </div>
                
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Navbar from './Navbar.vue';
import Sidebar from './Sidebar.vue';

const isMobile = ref(window.innerWidth < 1024);

const handleResize = () => {
    isMobile.value = window.innerWidth < 1024;
};

onMounted(() => {
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});
</script>
EOF

cat > "$JS/Components/Layout/GuestLayout.vue" << 'EOF'
<template>
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">
                    🏢 Gestion Location
                </Link>
            </div>
        </header>
        
        <main class="flex-1">
            <slot />
        </main>
        
        <footer class="bg-gray-800 text-white py-6">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; {{ new Date().getFullYear() }} Gestion Location. Tous droits réservés.</p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
EOF

cat > "$JS/Components/Layout/Navbar.vue" << 'EOF'
<template>
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <button @click="toggleSidebar" class="lg:hidden mr-4 text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <Link :href="route('dashboard')" class="text-xl font-bold text-indigo-600">
                        🏢 Gestion Location
                    </Link>
                </div>
                
                <div class="flex items-center space-x-4">
                    <NotificationBell />
                    
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                <span>{{ $page.props.auth.user.name }}</span>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </template>
                        
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">Profil</DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">Déconnexion</DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Common/Dropdown.vue';
import DropdownLink from '@/Components/Common/DropdownLink.vue';
import NotificationBell from '@/Components/Notifications/NotificationBell.vue';

const toggleSidebar = () => {
    // Logique toggle sidebar
};
</script>
EOF

cat > "$JS/Components/Layout/Sidebar.vue" << 'EOF'
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
EOF

echo "✓ Layouts créés (AppLayout, GuestLayout, Navbar, Sidebar)"

# ==========================================
# 4. COMPOSANTS COMMUNS
# ==========================================

cat > "$JS/Components/Common/Card.vue" << 'EOF'
<template>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 v-if="title" class="text-lg font-semibold mb-4">{{ title }}</h3>
        <slot />
    </div>
</template>

<script setup>
defineProps({
    title: String,
});
</script>
EOF

cat > "$JS/Components/Common/StatsCard.vue" << 'EOF'
<template>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">{{ title }}</p>
                <p class="text-2xl font-bold mt-2">{{ value }}</p>
            </div>
            <div :class="colorClass" class="text-4xl">{{ icon }}</div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: String,
    value: [String, Number],
    icon: String,
    color: String,
});

const colorClass = computed(() => {
    const colors = {
        blue: 'text-blue-500',
        green: 'text-green-500',
        purple: 'text-purple-500',
        orange: 'text-orange-500',
        red: 'text-red-500',
    };
    return colors[props.color] || 'text-gray-500';
});
</script>
EOF

cat > "$JS/Components/Common/Dropdown.vue" << 'EOF'
<template>
    <div class="relative">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>
        
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div v-show="open" class="absolute z-50 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                :class="alignmentClass"
                @click="open = false"
            >
                <div class="py-1">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    align: { type: String, default: 'right' },
    width: { type: String, default: '48' },
});

const open = ref(false);

const alignmentClass = computed(() => {
    if (props.align === 'left') return 'left-0';
    if (props.align === 'right') return 'right-0';
    return 'left-0';
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));
</script>
EOF

cat > "$JS/Components/Common/DropdownLink.vue" << 'EOF'
<template>
    <Link :href="href" :method="method" :as="as" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        <slot />
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    method: { type: String, default: 'get' },
    as: { type: String, default: 'a' },
});
</script>
EOF

cat > "$JS/Components/Common/SidebarLink.vue" << 'EOF'
<template>
    <Link :href="href" :class="linkClass" class="flex items-center px-4 py-3 rounded-lg transition">
        <span class="mr-3 text-xl"><slot name="icon" /></span>
        <span><slot /></span>
    </Link>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const linkClass = computed(() => 
    props.active
        ? 'bg-indigo-50 text-indigo-600 font-medium'
        : 'text-gray-700 hover:bg-gray-50'
);
</script>
EOF

cat > "$JS/Components/Common/Button.vue" << 'EOF'
<template>
    <button :type="type" :disabled="disabled" :class="buttonClass" class="px-4 py-2 rounded-lg font-medium transition">
        <slot />
    </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: { type: String, default: 'button' },
    variant: { type: String, default: 'primary' },
    disabled: Boolean,
});

const buttonClass = computed(() => {
    const variants = {
        primary: 'bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50',
        secondary: 'bg-gray-200 text-gray-700 hover:bg-gray-300',
        danger: 'bg-red-600 text-white hover:bg-red-700',
    };
    return variants[props.variant];
});
</script>
EOF

echo "✓ Composants communs créés (Card, StatsCard, Dropdown, Button, etc.)"

# ==========================================
# 5. CHARTS
# ==========================================

cat > "$JS/Components/Charts/LineChart.vue" << 'EOF'
<template>
    <div class="w-full h-64">
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps({
    data: Object,
});

const chartCanvas = ref(null);
let chartInstance = null;

const createChart = () => {
    if (chartInstance) chartInstance.destroy();
    
    chartInstance = new Chart(chartCanvas.value, {
        type: 'line',
        data: props.data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
        },
    });
};

onMounted(() => {
    if (props.data) createChart();
});

watch(() => props.data, () => {
    if (props.data) createChart();
});
</script>
EOF

cat > "$JS/Components/Charts/DoughnutChart.vue" << 'EOF'
<template>
    <div class="w-full h-64">
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps({
    data: Object,
});

const chartCanvas = ref(null);
let chartInstance = null;

const createChart = () => {
    if (chartInstance) chartInstance.destroy();
    
    chartInstance = new Chart(chartCanvas.value, {
        type: 'doughnut',
        data: props.data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
        },
    });
};

onMounted(() => {
    if (props.data) createChart();
});

watch(() => props.data, () => {
    if (props.data) createChart();
});
</script>
EOF

echo "✓ Composants Charts créés"

# ==========================================
# 6. NOTIFICATIONS
# ==========================================

cat > "$JS/Components/Notifications/NotificationBell.vue" << 'EOF'
<template>
    <div class="relative">
        <button @click="showNotifications = !showNotifications" class="relative p-2 text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span v-if="unreadCount > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ unreadCount }}
            </span>
        </button>
        
        <NotificationList v-if="showNotifications" @close="showNotifications = false" />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import NotificationList from './NotificationList.vue';

const page = usePage();
const showNotifications = ref(false);
const unreadCount = computed(() => page.props.unreadNotifications || 0);
</script>
EOF

cat > "$JS/Components/Notifications/NotificationList.vue" << 'EOF'
<template>
    <div class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50">
        <div class="p-4 border-b">
            <h3 class="font-semibold">Notifications</h3>
        </div>
        <div class="max-h-96 overflow-y-auto">
            <div v-if="!notifications.length" class="p-4 text-center text-gray-500">
                Aucune notification
            </div>
            <div v-for="notification in notifications" :key="notification.id" 
                class="p-4 border-b hover:bg-gray-50 cursor-pointer">
                <p class="text-sm">{{ notification.data.message }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ notification.created_at }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const notifications = ref([]);
</script>
EOF

echo "✓ Composants Notifications créés"

# ==========================================
# 7. PAGES - WELCOME & DASHBOARD
# ==========================================

cat > "$JS/Pages/Welcome.vue" << 'EOF'
<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
        <div class="container mx-auto px-4 py-16">
            <div class="flex justify-between items-center mb-16">
                <h1 class="text-4xl font-bold text-white">🏢 Gestion Location</h1>
                <div class="space-x-4">
                    <Link v-if="canLogin" :href="route('login')" 
                        class="px-6 py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Connexion
                    </Link>
                    <Link v-if="canRegister" :href="route('register')" 
                        class="px-6 py-3 bg-indigo-700 text-white rounded-lg font-semibold hover:bg-indigo-800 transition">
                        Inscription
                    </Link>
                </div>
            </div>

            <div class="text-center text-white mb-20">
                <h2 class="text-5xl font-extrabold mb-6">
                    Gérez vos biens immobiliers en toute simplicité
                </h2>
                <p class="text-xl mb-8 text-indigo-100">
                    Contrats, paiements, maintenance - tout au même endroit
                </p>
                <Link :href="route('register')" 
                    class="inline-block px-8 py-4 bg-white text-indigo-600 rounded-lg text-lg font-bold hover:bg-gray-100 transition shadow-lg">
                    Commencer gratuitement →
                </Link>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 text-white">
                    <div class="text-4xl mb-4">🏠</div>
                    <h3 class="text-xl font-bold mb-3">Gestion des Biens</h3>
                    <p class="text-indigo-100">Enregistrez et gérez tous vos biens immobiliers</p>
                </div>

                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 text-white">
                    <div class="text-4xl mb-4">📝</div>
                    <h3 class="text-xl font-bold mb-3">Contrats Électroniques</h3>
                    <p class="text-indigo-100">Signature électronique et génération PDF automatique</p>
                </div>

                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 text-white">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="text-xl font-bold mb-3">Paiements & Facturation</h3>
                    <p class="text-indigo-100">Génération automatique de quittances</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>
EOF

cat > "$JS/Pages/Dashboard.vue" << 'EOF'
<template>
    <AppLayout title="Tableau de bord">
        <div class="py-6">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">Tableau de bord</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <StatsCard 
                        v-for="(stat, key) in displayStats" 
                        :key="key"
                        :title="stat.title"
                        :value="stat.value"
                        :icon="stat.icon"
                        :color="stat.color"
                    />
                </div>

                <div v-if="stats?.revenueData" class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <Card title="Revenus Mensuels">
                        <LineChart :data="revenueChartData" />
                    </Card>

                    <Card title="Statut des Biens">
                        <DoughnutChart :data="propertyStatusData" />
                    </Card>
                </div>

                <Card v-if="hasActiveContract === false" class="text-center py-12">
                    <div class="text-6xl mb-4">🏠</div>
                    <h3 class="text-xl font-semibold mb-2">Aucun contrat actif</h3>
                    <p class="text-gray-600">Vous n'avez pas de contrat de location actuellement.</p>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue';
import AppLayout from '@/Components/Layout/AppLayout.vue';
import StatsCard from '@/Components/Common/StatsCard.vue';
import Card from '@/Components/Common/Card.vue';
import LineChart from '@/Components/Charts/LineChart.vue';
import DoughnutChart from '@/Components/Charts/DoughnutChart.vue';

const props = defineProps({
    stats: Object,
    revenueData: Array,
    propertyStatus: Object,
    hasActiveContract: Boolean,
});

const displayStats = computed(() => {
    const stats = props.stats || {};
    return [
        { title: 'Biens Totaux', value: stats.total_properties || stats.my_properties || 0, icon: '🏠', color: 'blue' },
        { title: 'Contrats Actifs', value: stats.active_contracts || 0, icon: '📝', color: 'green' },
        { title: 'Revenus du Mois', value: formatCurrency(stats.monthly_revenue || stats.monthly_income || 0), icon: '💰', color: 'purple' },
        { title: 'Réclamations', value: stats.pending_maintenance || 0, icon: '🔧', color: 'orange' },
    ];
});

const revenueChartData = computed(() => {
    if (!props.revenueData) return null;
    return {
        labels: props.revenueData.map(item => item.month),
        datasets: [{
            label: 'Revenus',
            data: props.revenueData.map(item => item.amount),
            borderColor: 'rgb(99, 102, 241)',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.4,
        }]
    };
});

const propertyStatusData = computed(() => {
    if (!props.propertyStatus) return null;
    return {
        labels: Object.keys(props.propertyStatus),
        datasets: [{
            data: Object.values(props.propertyStatus),
            backgroundColor: ['rgb(34, 197, 94)', 'rgb(234, 179, 8)', 'rgb(239, 68, 68)']
        }]
    };
});

function formatCurrency(amount) {
    return new Intl.NumberFormat('fr-FR').format(amount) + ' FCFA';
}
</script>
EOF

echo "✓ Pages Welcome et Dashboard créées"

# ==========================================
# 8. PAGES AUTH (5 fichiers)
# ==========================================

cat > "$JS/Pages/Auth/Login.vue" << 'EOF'
<template>
    <GuestLayout title="Connexion">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">Connexion</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Ou
                        <Link :href="route('register')" class="font-medium text-indigo-600 hover:text-indigo-500">
                            créer un nouveau compte
                        </Link>
                    </p>
                </div>

                <form @submit.prevent="submit" class="bg-white p-8 rounded-lg shadow space-y-6">
                    <div v-if="status" class="p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                        {{ status }}
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            autofocus
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            :class="{ 'border-red-300': form.errors.email }"
                        />
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            :class="{ 'border-red-300': form.errors.password }"
                        />
                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input v-model="form.remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-900">Se souvenir de moi</span>
                        </label>

                        <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-indigo-600 hover:text-indigo-500">
                            Mot de passe oublié ?
                        </Link>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-3 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 disabled:opacity-50 transition"
                    >
                        {{ form.processing ? 'Connexion...' : 'Se connecter' }}
                    </button>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
EOF

cat > "$JS/Pages/Auth/Register.vue" << 'EOF'
<template>
    <GuestLayout title="Inscription">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">Créer un compte</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Ou
                        <Link :href="route('login')" class="font-medium text-indigo-600 hover:text-indigo-500">
                            se connecter
                        </Link>
                    </p>
                </div>

                <form @submit.prevent="submit" class="bg-white p-8 rounded-lg shadow space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
                            :class="{ 'border-red-300': form.errors.name }"
                        />
                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
                            :class="{ 'border-red-300': form.errors.email }"
                        />
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <input
                            v-model="form.password"
                            type="password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
                            :class="{ 'border-red-300': form.errors.password }"
                        />
                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-3 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Inscription...' : "S'inscrire" }}
                    </button>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
EOF

cat > "$JS/Pages/Auth/ForgotPassword.vue" << 'EOF'
<template>
    <GuestLayout title="Mot de passe oublié">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">Mot de passe oublié ?</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Entrez votre email pour recevoir un lien de réinitialisation
                    </p>
                </div>

                <form @submit.prevent="submit" class="bg-white p-8 rounded-lg shadow space-y-6">
                    <div v-if="status" class="p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                        {{ status }}
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md"
                        />
                    </div>

                    <div class="flex items-center justify-between">
                        <Link :href="route('login')" class="text-sm text-indigo-600 hover:text-indigo-500">
                            ← Retour
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50"
                        >
                            Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

defineProps({ status: String });

const form = useForm({ email: '' });
const submit = () => form.post(route('password.email'));
</script>
EOF

cat > "$JS/Pages/Auth/ResetPassword.vue" << 'EOF'
<template>
    <GuestLayout title="Réinitialisation">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <h2 class="text-center text-3xl font-extrabold text-gray-900 mb-8">Nouveau mot de passe</h2>

                <form @submit.prevent="submit" class="bg-white p-8 rounded-lg shadow space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input v-model="form.email" type="email" required class="w-full px-3 py-2 border rounded-md" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                        <input v-model="form.password" type="password" required class="w-full px-3 py-2 border rounded-md" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer</label>
                        <input v-model="form.password_confirmation" type="password" required class="w-full px-3 py-2 border rounded-md" />
                    </div>

                    <button type="submit" :disabled="form.processing" class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50">
                        Réinitialiser
                    </button>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

const props = defineProps({ email: String, token: String });

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => form.post(route('password.store'));
</script>
EOF

cat > "$JS/Pages/Auth/VerifyEmail.vue" << 'EOF'
<template>
    <GuestLayout title="Vérification email">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full">
                <div class="bg-white p-8 rounded-lg shadow text-center">
                    <div class="text-6xl mb-4">📧</div>
                    <h2 class="text-2xl font-bold mb-4">Vérifiez votre email</h2>
                    
                    <p class="text-gray-600 mb-6">
                        Un lien de vérification a été envoyé à votre adresse email.
                    </p>

                    <div v-if="status === 'verification-link-sent'" 
                        class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                        Un nouveau lien a été envoyé.
                    </div>

                    <form @submit.prevent="submit">
                        <button type="submit" :disabled="form.processing" class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50">
                            Renvoyer l'email
                        </button>
                    </form>

                    <Link :href="route('logout')" method="post" as="button" class="mt-4 text-sm text-gray-600 hover:text-gray-900">
                        Se déconnecter
                    </Link>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Components/Layout/GuestLayout.vue';

defineProps({ status: String });

const form = useForm({});
const submit = () => form.post(route('verification.send'));
</script>
EOF

echo "✓ Pages Auth créées (Login, Register, ForgotPassword, ResetPassword, VerifyEmail)"

# ==========================================
# 9. PAGES PROFILE
# ==========================================

cat > "$JS/Pages/Profile/Edit.vue" << 'EOF'
<template>
    <AppLayout title="Profil">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <UpdateProfileInformationForm :mustVerifyEmail="mustVerifyEmail" :status="status" />
                <UpdatePasswordForm />
                <DeleteUserForm />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>
EOF

cat > "$JS/Pages/Profile/Partials/UpdateProfileInformationForm.vue" << 'EOF'
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
EOF

cat > "$JS/Pages/Profile/Partials/UpdatePasswordForm.vue" << 'EOF'
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
EOF

cat > "$JS/Pages/Profile/Partials/DeleteUserForm.vue" << 'EOF'
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
EOF

echo "✓ Pages Profile créées"

# ==========================================
# 10. UTILS
# ==========================================

cat > "$JS/Utils/formatters.js" << 'EOF'
export const formatCurrency = (amount) => {
    return new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount) + ' FCFA';
};

export const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR');
};

export const formatDateTime = (date) => {
    return new Date(date).toLocaleString('fr-FR');
};
EOF

cat > "$JS/Utils/helpers.js" << 'EOF'
export const truncate = (text, length = 100) => {
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
};

export const slugify = (text) => {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-');
};
EOF

cat > "$JS/Utils/constants.js" << 'EOF'
export const PROPERTY_TYPES = {
    apartment: 'Appartement',
    house: 'Maison',
    villa: 'Villa',
    studio: 'Studio',
    office: 'Bureau',
};

export const PROPERTY_STATUSES = {
    available: 'Disponible',
    rented: 'Loué',
    maintenance: 'En maintenance',
};

export const CONTRACT_STATUSES = {
    draft: 'Brouillon',
    active: 'Actif',
    expired: 'Expiré',
    terminated: 'Résilié',
};

export const PAYMENT_STATUSES = {
    pending: 'En attente',
    paid: 'Payé',
    late: 'En retard',
};
EOF

echo "✓ Utilitaires créés (formatters, helpers, constants)"

# ==========================================
# 11. COMPOSABLES
# ==========================================

cat > "$JS/Composables/useAuth.js" << 'EOF'
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export function useAuth() {
    const page = usePage();
    
    const user = computed(() => page.props.auth.user);
    const isAdmin = computed(() => user.value.roles?.includes('admin'));
    const isOwner = computed(() => user.value.roles?.includes('proprietaire'));
    const isTenant = computed(() => user.value.roles?.includes('locataire'));
    
    const can = (permission) => {
        return user.value.permissions?.includes(permission) || isAdmin.value;
    };
    
    return {
        user,
        isAdmin,
        isOwner,
        isTenant,
        can,
    };
}
EOF

cat > "$JS/Composables/usePermissions.js" << 'EOF'
import { useAuth } from './useAuth';

export function usePermissions() {
    const { can } = useAuth();
    
    return {
        canViewProperties: () => can('view-any-properties'),
        canCreateProperty: () => can('create-property'),
        canViewContracts: () => can('view-any-contracts'),
        canCreateContract: () => can('create-contract'),
        canViewPayments: () => can('view-any-payments'),
        canProcessPayment: () => can('process-payment'),
    };
}
EOF

echo "✓ Composables créés (useAuth, usePermissions)"

# ==========================================
# 12. STORES (PINIA)
# ==========================================

cat > "$JS/Stores/auth.js" << 'EOF'
import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export const useAuthStore = defineStore('auth', () => {
    const page = usePage();
    const user = computed(() => page.props.auth.user);
    
    const isAuthenticated = computed(() => !!user.value);
    const isAdmin = computed(() => user.value?.roles?.includes('admin'));
    
    return {
        user,
        isAuthenticated,
        isAdmin,
    };
});
EOF

cat > "$JS/Stores/notifications.js" << 'EOF'
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useNotificationStore = defineStore('notifications', () => {
    const notifications = ref([]);
    const unreadCount = ref(0);
    
    const addNotification = (notification) => {
        notifications.value.unshift(notification);
        unreadCount.value++;
    };
    
    const markAsRead = (id) => {
        const notification = notifications.value.find(n => n.id === id);
        if (notification && !notification.read) {
            notification.read = true;
            unreadCount.value--;
        }
    };
    
    const markAllAsRead = () => {
        notifications.value.forEach(n => n.read = true);
        unreadCount.value = 0;
    };
    
    return {
        notifications,
        unreadCount,
        addNotification,
        markAsRead,
        markAllAsRead,
    };
});
EOF

cat > "$JS/Stores/ui.js" << 'EOF'
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useUIStore = defineStore('ui', () => {
    const sidebarOpen = ref(true);
    const mobileMenuOpen = ref(false);
    
    const toggleSidebar = () => {
        sidebarOpen.value = !sidebarOpen.value;
    };
    
    const toggleMobileMenu = () => {
        mobileMenuOpen.value = !mobileMenuOpen.value;
    };
    
    return {
        sidebarOpen,
        mobileMenuOpen,
        toggleSidebar,
        toggleMobileMenu,
    };
});
EOF

echo "✓ Stores Pinia créés (auth, notifications, ui)"

# ==========================================
# 13. PACKAGE.JSON DEPENDENCIES
# ==========================================

cat > "$PROJECT_PATH/frontend-dependencies.txt" << 'EOF'
📦 Dépendances à installer:

npm install

# Dépendances de base (déjà installées par Breeze)
@inertiajs/vue3
vue
pinia
axios

# Charts
npm install chart.js

# Utilitaires
npm install date-fns

# Icons (optionnel)
npm install @heroicons/vue

# Validation (optionnel)
npm install vee-validate yup
EOF

echo "✓ Liste des dépendances créée (frontend-dependencies.txt)"

# ==========================================
# FINALISATION
# ==========================================

echo ""
echo "╔════════════════════════════════════════════════╗"
echo "║  ✅ GÉNÉRATION COMPLÈTE RÉUSSIE ! ✅          ║"
echo "╚════════════════════════════════════════════════╝"
echo ""
echo "📁 Emplacement: $JS"
echo ""
echo "📊 Statistiques:"
echo "  • Layouts: 4 fichiers (AppLayout, GuestLayout, Navbar, Sidebar)"
echo "  • Composants: 10+ fichiers (Card, StatsCard, Dropdown, Button, Charts, etc.)"
echo "  • Pages: 11 fichiers (Welcome, Dashboard, Auth x5, Profile x3)"
echo "  • Composables: 2 fichiers (useAuth, usePermissions)"
echo "  • Stores: 3 fichiers (auth, notifications, ui)"
echo "  • Utils: 3 fichiers (formatters, helpers, constants)"
echo ""
echo "📦 Prochaines étapes:"
echo ""
echo "1. Installer les dépendances:"
echo "   cd $PROJECT_PATH"
echo "   npm install"
echo "   npm install chart.js date-fns"
echo ""
echo "2. Compiler les assets:"
echo "   npm run dev"
echo ""
echo "3. Lancer le serveur Laravel:"
echo "   php artisan serve"
echo ""
echo "4. Accéder à l'application:"
echo "   http://localhost:8000"
echo ""
echo "💡 Fichiers à créer ensuite:"
echo "  • Pages/Users (Index, Create, Edit, Show)"
echo "  • Pages/Properties (Index, Create, Edit, Show + Partials)"
echo "  • Pages/Contracts (Index, Create, Edit, Show + Partials)"
echo "  • Pages/Payments (Index, Show + Partials)"
echo "  • Pages/Maintenance (Index, Create, Show + Partials)"
echo "  • Pages/Reports (Overview, Financial, etc.)"
echo ""
echo "📚 Documentation:"
echo "  • Vue 3: https://vuejs.org"
echo "  • Inertia.js: https://inertiajs.com"
echo "  • Tailwind CSS: https://tailwindcss.com"
echo "  • Pinia: https://pinia.vuejs.org"
echo ""
echo "🎉 Frontend de base prêt à l'emploi !"
echo ""