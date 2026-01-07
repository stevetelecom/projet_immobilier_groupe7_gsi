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
