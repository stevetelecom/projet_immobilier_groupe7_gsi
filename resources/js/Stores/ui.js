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
