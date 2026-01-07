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
