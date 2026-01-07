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
