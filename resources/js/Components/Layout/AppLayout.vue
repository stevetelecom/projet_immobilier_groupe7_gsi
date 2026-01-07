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
