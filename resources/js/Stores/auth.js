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
