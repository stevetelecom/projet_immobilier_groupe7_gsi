<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    | Canaux de notification disponibles: database, mail, sms, slack, etc.
    */

    'channels' => [
        'database' => [
            'enabled' => true,
        ],
        'mail' => [
            'enabled' => env('NOTIFICATION_MAIL_ENABLED', true),
        ],
        'sms' => [
            'enabled' => env('NOTIFICATION_SMS_ENABLED', false),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Types Configuration
    |--------------------------------------------------------------------------
    | Configuration des différents types de notifications
    */

    'types' => [
        // Notifications pour les paiements
        'payment' => [
            'reminder_days_before' => env('PAYMENT_REMINDER_DAYS', 7),
            'overdue_reminder_days' => [3, 7, 14, 30], // Rappels après échéance
        ],

        // Notifications pour les contrats
        'contract' => [
            'expiry_reminder_days' => env('CONTRACT_EXPIRY_REMINDER_DAYS', 30),
            'renewal_reminder_days' => [60, 30, 15], // 60, 30, 15 jours avant expiration
        ],

        // Notifications pour les maintenances
        'maintenance' => [
            'urgent_notification' => true,
            'high_priority_notification' => true,
            'completion_notification' => true,
        ],

        // Notifications pour les documents
        'documents' => [
            'new_document_notification' => true,
            'document_expiry_reminder_days' => 30,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Schedules
    |--------------------------------------------------------------------------
    | Planification des notifications automatiques
    */

    'schedules' => [
        // Vérifier les paiements en retard (tous les jours à 9h)
        'check_overdue_payments' => [
            'enabled' => true,
            'frequency' => 'daily',
            'time' => '09:00',
        ],

        // Vérifier les contrats expirant bientôt (tous les jours à 10h)
        'check_expiring_contracts' => [
            'enabled' => true,
            'frequency' => 'daily',
            'time' => '10:00',
        ],

        // Générer les paiements mensuels (le 1er de chaque mois à 00:00)
        'generate_monthly_payments' => [
            'enabled' => true,
            'frequency' => 'monthly',
            'day' => 1,
            'time' => '00:00',
        ],

        // Rappels de paiement (7 jours avant échéance)
        'send_payment_reminders' => [
            'enabled' => true,
            'frequency' => 'daily',
            'time' => '08:00',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Recipients by Role
    |--------------------------------------------------------------------------
    | Définir qui reçoit quel type de notification selon le rôle
    */

    'recipients' => [
        'admin' => [
            'new_user_registration',
            'urgent_maintenance_request',
            'payment_issue',
            'contract_issue',
            'system_notification',
        ],

        'proprietaire' => [
            'new_contract',
            'contract_signed',
            'contract_expiring',
            'payment_received',
            'payment_overdue',
            'maintenance_request',
            'maintenance_completed',
            'tenant_message',
        ],

        'locataire' => [
            'contract_created',
            'contract_signed',
            'contract_expiring',
            'payment_due',
            'payment_validated',
            'payment_rejected',
            'maintenance_status_updated',
            'owner_message',
        ],

        'agent' => [
            'new_property',
            'property_updated',
            'maintenance_assigned',
            'maintenance_status_updated',
            'contract_issue',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Templates
    |--------------------------------------------------------------------------
    | Configuration des templates d'emails
    */

    'email' => [
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'noreply@gestion-location.cm'),
            'name' => env('MAIL_FROM_NAME', 'Gestion Location'),
        ],

        'reply_to' => [
            'address' => env('MAIL_REPLY_TO_ADDRESS', 'support@gestion-location.cm'),
            'name' => env('MAIL_REPLY_TO_NAME', 'Support Gestion Location'),
        ],

        'templates' => [
            'payment_reminder' => 'emails.payment-reminder',
            'payment_overdue' => 'emails.payment-overdue',
            'contract_created' => 'emails.contract-created',
            'contract_signed' => 'emails.contract-signed',
            'contract_expiring' => 'emails.contract-expiring',
            'maintenance_created' => 'emails.maintenance-created',
            'maintenance_updated' => 'emails.maintenance-updated',
        ],

        'footer' => [
            'company_name' => config('app.name'),
            'company_address' => env('COMPANY_ADDRESS', 'Yaoundé, Cameroun'),
            'company_phone' => env('COMPANY_PHONE', '+237 6XX XX XX XX'),
            'company_email' => env('COMPANY_EMAIL', 'contact@gestion-location.cm'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SMS Configuration
    |--------------------------------------------------------------------------
    | Configuration pour les notifications SMS
    */

    'sms' => [
        'provider' => env('SMS_PROVIDER', 'twilio'),
        
        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],

        'templates' => [
            'payment_reminder' => 'Rappel: Votre loyer de {amount} est dû le {date}. Merci.',
            'payment_overdue' => 'Alerte: Votre loyer de {amount} est en retard. Veuillez régulariser.',
            'contract_expiring' => 'Info: Votre contrat expire le {date}. Contactez-nous pour le renouvellement.',
            'maintenance_created' => 'Votre demande de maintenance #{id} a été enregistrée.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | In-App Notification Settings
    |--------------------------------------------------------------------------
    */

    'in_app' => [
        'enabled' => true,
        'retention_days' => 90, // Supprimer les notifications après 90 jours
        'mark_read_after_days' => 30, // Marquer comme lu automatiquement après 30 jours
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Preferences
    |--------------------------------------------------------------------------
    | Permettre aux utilisateurs de gérer leurs préférences
    */

    'user_preferences' => [
        'enabled' => true,
        'default_channels' => ['database', 'mail'],
    ],

];
