<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Information
    |--------------------------------------------------------------------------
    */

    'app' => [
        'name' => env('APP_NAME', 'Gestion Location'),
        'company_name' => env('COMPANY_NAME', 'Gestion Location SARL'),
        'address' => env('COMPANY_ADDRESS', 'Yaoundé, Cameroun'),
        'phone' => env('COMPANY_PHONE', '+237 6XX XX XX XX'),
        'email' => env('COMPANY_EMAIL', 'contact@gestion-location.cm'),
        'website' => env('APP_URL', 'http://localhost:8000'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    */

    'currency' => [
        'code' => env('DEFAULT_CURRENCY', 'XAF'),
        'symbol' => env('DEFAULT_CURRENCY_SYMBOL', 'FCFA'),
        'position' => 'after', // before or after amount
        'decimal_separator' => ',',
        'thousand_separator' => ' ',
        'decimals' => 0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax Configuration
    |--------------------------------------------------------------------------
    */

    'tax' => [
        'enabled' => env('TAX_ENABLED', true),
        'rate' => env('TAX_RATE', 19.25), // TVA Cameroun
        'label' => 'TVA',
        'include_in_price' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Property Configuration
    |--------------------------------------------------------------------------
    */

    'property' => [
        // Types de biens
        'types' => [
            'apartment' => 'Appartement',
            'house' => 'Maison',
            'villa' => 'Villa',
            'studio' => 'Studio',
            'duplex' => 'Duplex',
            'office' => 'Bureau',
            'shop' => 'Boutique',
            'warehouse' => 'Entrepôt',
            'land' => 'Terrain',
            'other' => 'Autre',
        ],

        // Statuts
        'statuses' => [
            'available' => 'Disponible',
            'occupied' => 'Occupé',
            'maintenance' => 'En maintenance',
            'unavailable' => 'Indisponible',
        ],

        // Configuration des images
        'images' => [
            'max_count' => 10,
            'max_size' => 5120, // 5MB en Ko
            'required_count' => 1,
        ],

        // Configuration des documents
        'documents' => [
            'max_count' => 5,
            'max_size' => 10240, // 10MB en Ko
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Contract Configuration
    |--------------------------------------------------------------------------
    */

    'contract' => [
        // Durée minimale et maximale en mois
        'min_duration_months' => env('CONTRACT_MIN_DURATION_MONTHS', 3),
        'max_duration_months' => env('CONTRACT_MAX_DURATION_MONTHS', 60),
        'default_duration_months' => env('CONTRACT_DEFAULT_DURATION_MONTHS', 12),

        // Statuts
        'statuses' => [
            'draft' => 'Brouillon',
            'pending' => 'En attente',
            'signed' => 'Signé',
            'active' => 'Actif',
            'expired' => 'Expiré',
            'terminated' => 'Résilié',
        ],

        // Configuration de la caution
        'deposit' => [
            'required' => true,
            'min_months' => 1,
            'max_months' => 3,
            'default_months' => 2,
        ],

        // Rappels avant expiration
        'expiry_reminder_days' => [60, 30, 15, 7],

        // Renouvellement automatique
        'auto_renewal' => [
            'enabled' => false,
            'notify_before_days' => 30,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Configuration
    |--------------------------------------------------------------------------
    */

    'payment' => [
        // Statuts
        'statuses' => [
            'pending' => 'En attente',
            'validated' => 'Validé',
            'rejected' => 'Rejeté',
            'late' => 'En retard',
        ],

        // Méthodes de paiement
        'methods' => [
            'cash' => 'Espèces',
            'bank_transfer' => 'Virement bancaire',
            'mobile_money' => 'Mobile Money',
            'check' => 'Chèque',
            'card' => 'Carte bancaire',
        ],

        // Configuration des pénalités
        'late_penalty' => [
            'enabled' => true,
            'rate' => env('LATE_PAYMENT_PENALTY_PERCENT', 10), // Pourcentage
            'grace_period_days' => env('PAYMENT_GRACE_PERIOD_DAYS', 5),
        ],

        // Rappels de paiement
        'reminders' => [
            'enabled' => true,
            'days_before' => [7, 3, 1], // Jours avant l'échéance
            'days_after' => [3, 7, 14, 30], // Jours après l'échéance
        ],

        // Génération automatique
        'auto_generation' => [
            'enabled' => true,
            'day_of_month' => 1, // Générer le 1er de chaque mois
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice Configuration
    |--------------------------------------------------------------------------
    */

    'invoice' => [
        // Préfixe des numéros de facture
        'prefix' => 'FACT',
        
        // Numéro de départ
        'starting_number' => 1000,

        // Format du numéro
        'number_format' => '{prefix}-{year}{month}-{number}',

        // Statuts
        'statuses' => [
            'draft' => 'Brouillon',
            'sent' => 'Envoyée',
            'paid' => 'Payée',
            'overdue' => 'En retard',
            'cancelled' => 'Annulée',
        ],

        // Configuration PDF
        'pdf' => [
            'orientation' => 'portrait',
            'paper_size' => 'a4',
            'include_logo' => true,
            'include_watermark' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Request Configuration
    |--------------------------------------------------------------------------
    */

    'maintenance' => [
        // Priorités
        'priorities' => [
            'low' => [
                'label' => 'Basse',
                'response_time_hours' => 168, // 7 jours
                'color' => 'gray',
            ],
            'normal' => [
                'label' => 'Normale',
                'response_time_hours' => 72, // 3 jours
                'color' => 'blue',
            ],
            'high' => [
                'label' => 'Haute',
                'response_time_hours' => 24, // 1 jour
                'color' => 'orange',
            ],
            'urgent' => [
                'label' => 'Urgente',
                'response_time_hours' => 4, // 4 heures
                'color' => 'red',
            ],
        ],

        // Statuts
        'statuses' => [
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'completed' => 'Terminée',
            'cancelled' => 'Annulée',
        ],

        // Configuration des images
        'images' => [
            'max_count' => 5,
            'max_size' => 5120, // 5MB en Ko
        ],

        // Notifications
        'notifications' => [
            'notify_owner' => true,
            'notify_admin_for_urgent' => true,
            'notify_tenant_on_status_change' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reports Configuration
    |--------------------------------------------------------------------------
    */

    'reports' => [
        // Types de rapports disponibles
        'types' => [
            'financial' => 'Rapport financier',
            'occupancy' => 'Taux d\'occupation',
            'payments' => 'État des paiements',
            'maintenance' => 'Maintenance',
            'contracts' => 'Contrats',
        ],

        // Formats d'export
        'export_formats' => ['pdf', 'excel', 'csv'],

        // Périodes prédéfinies
        'periods' => [
            'current_month' => 'Mois en cours',
            'last_month' => 'Mois dernier',
            'current_quarter' => 'Trimestre en cours',
            'last_quarter' => 'Trimestre dernier',
            'current_year' => 'Année en cours',
            'last_year' => 'Année dernière',
            'custom' => 'Période personnalisée',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Configuration
    |--------------------------------------------------------------------------
    */

    'dashboard' => [
        // Widgets disponibles par rôle
        'widgets' => [
            'admin' => [
                'total_properties',
                'total_contracts',
                'monthly_revenue',
                'overdue_payments',
                'pending_maintenance',
                'recent_activities',
                'occupancy_rate',
                'revenue_chart',
            ],
            'proprietaire' => [
                'my_properties',
                'active_contracts',
                'monthly_income',
                'overdue_payments',
                'pending_maintenance',
                'recent_activities',
            ],
            'locataire' => [
                'my_contract',
                'next_payment',
                'payment_history',
                'my_maintenance_requests',
                'property_details',
            ],
            'agent' => [
                'assigned_properties',
                'active_contracts',
                'pending_tasks',
                'maintenance_requests',
                'recent_activities',
            ],
        ],

        // Rafraîchissement automatique (en secondes)
        'auto_refresh' => 300, // 5 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | User Roles & Permissions
    |--------------------------------------------------------------------------
    */

    'roles' => [
        'admin' => 'Administrateur',
        'proprietaire' => 'Propriétaire',
        'locataire' => 'Locataire',
        'agent' => 'Agent Immobilier',
    ],

];
