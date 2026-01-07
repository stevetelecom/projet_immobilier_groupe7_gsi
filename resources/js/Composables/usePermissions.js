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
