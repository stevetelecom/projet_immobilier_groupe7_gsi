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
