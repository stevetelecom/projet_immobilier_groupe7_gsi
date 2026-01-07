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
