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
