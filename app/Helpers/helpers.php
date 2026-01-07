<?php

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

if (!function_exists('format_currency')) {
    /**
     * Formater un montant en devise locale (FCFA)
     *
     * @param float $amount
     * @param string|null $symbol
     * @return string
     */
    function format_currency($amount, $symbol = null)
    {
        $symbol = $symbol ?? config('app.currency_symbol', 'FCFA');
        return number_format($amount, 0, ',', ' ') . ' ' . $symbol;
    }
}

if (!function_exists('format_date')) {
    /**
     * Formater une date au format local
     *
     * @param string|Carbon $date
     * @param string $format
     * @return string|null
     */
    function format_date($date, $format = 'd/m/Y')
    {
        if (!$date) {
            return null;
        }
        
        return Carbon::parse($date)->format($format);
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Formater une date et heure au format local
     *
     * @param string|Carbon $datetime
     * @param string $format
     * @return string|null
     */
    function format_datetime($datetime, $format = 'd/m/Y H:i')
    {
        if (!$datetime) {
            return null;
        }
        
        return Carbon::parse($datetime)->format($format);
    }
}

if (!function_exists('calculate_late_payment_penalty')) {
    /**
     * Calculer la pénalité de retard de paiement
     *
     * @param float $amount
     * @param int $daysLate
     * @return float
     */
    function calculate_late_payment_penalty($amount, $daysLate)
    {
        if ($daysLate <= 0) {
            return 0;
        }

        $penaltyRate = config('app.late_payment_penalty_percent', 10);
        return ($amount * $penaltyRate) / 100;
    }
}

if (!function_exists('days_until')) {
    /**
     * Calculer le nombre de jours jusqu'à une date
     *
     * @param string|Carbon $date
     * @return int
     */
    function days_until($date)
    {
        if (!$date) {
            return 0;
        }
        
        return Carbon::now()->diffInDays(Carbon::parse($date), false);
    }
}

if (!function_exists('generate_reference_number')) {
    /**
     * Générer un numéro de référence unique
     *
     * @param string $prefix
     * @param int|null $id
     * @return string
     */
    function generate_reference_number($prefix, $id = null)
    {
        $year = date('Y');
        $month = date('m');
        $id = $id ?? rand(1000, 9999);
        
        return strtoupper($prefix) . '-' . $year . $month . '-' . str_pad($id, 6, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('get_property_status_label')) {
    /**
     * Obtenir le label d'un statut de bien
     *
     * @param string $status
     * @return string
     */
    function get_property_status_label($status)
    {
        $labels = [
            'available' => 'Disponible',
            'occupied' => 'Occupé',
            'maintenance' => 'En maintenance',
            'unavailable' => 'Indisponible',
        ];
        
        return $labels[$status] ?? $status;
    }
}

if (!function_exists('get_contract_status_label')) {
    /**
     * Obtenir le label d'un statut de contrat
     *
     * @param string $status
     * @return string
     */
    function get_contract_status_label($status)
    {
        $labels = [
            'draft' => 'Brouillon',
            'pending' => 'En attente',
            'signed' => 'Signé',
            'active' => 'Actif',
            'expired' => 'Expiré',
            'terminated' => 'Résilié',
        ];
        
        return $labels[$status] ?? $status;
    }
}

if (!function_exists('get_payment_status_label')) {
    /**
     * Obtenir le label d'un statut de paiement
     *
     * @param string $status
     * @return string
     */
    function get_payment_status_label($status)
    {
        $labels = [
            'pending' => 'En attente',
            'validated' => 'Validé',
            'rejected' => 'Rejeté',
            'late' => 'En retard',
        ];
        
        return $labels[$status] ?? $status;
    }
}

if (!function_exists('get_maintenance_priority_label')) {
    /**
     * Obtenir le label d'une priorité de maintenance
     *
     * @param string $priority
     * @return string
     */
    function get_maintenance_priority_label($priority)
    {
        $labels = [
            'low' => 'Basse',
            'normal' => 'Normale',
            'high' => 'Haute',
            'urgent' => 'Urgente',
        ];
        
        return $labels[$priority] ?? $priority;
    }
}

if (!function_exists('get_maintenance_status_label')) {
    /**
     * Obtenir le label d'un statut de maintenance
     *
     * @param string $status
     * @return string
     */
    function get_maintenance_status_label($status)
    {
        $labels = [
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'completed' => 'Terminée',
            'cancelled' => 'Annulée',
        ];
        
        return $labels[$status] ?? $status;
    }
}

if (!function_exists('upload_file')) {
    /**
     * Upload un fichier vers un disque
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $disk
     * @param string|null $directory
     * @return string|false
     */
    function upload_file($file, $disk, $directory = null)
    {
        try {
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $directory ? $directory . '/' . $filename : $filename;
            
            Storage::disk($disk)->put($path, file_get_contents($file));
            
            return $path;
        } catch (\Exception $e) {
            \Log::error('Error uploading file: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('delete_file')) {
    /**
     * Supprimer un fichier d'un disque
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    function delete_file($path, $disk)
    {
        try {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->delete($path);
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Error deleting file: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('get_file_url')) {
    /**
     * Obtenir l'URL d'un fichier
     *
     * @param string $path
     * @param string $disk
     * @return string|null
     */
    function get_file_url($path, $disk)
    {
        if (!$path || !Storage::disk($disk)->exists($path)) {
            return null;
        }
        
        return Storage::disk($disk)->url($path);
    }
}

if (!function_exists('calculate_contract_balance')) {
    /**
     * Calculer le solde d'un contrat (loyers restants à payer)
     *
     * @param \App\Models\Contract $contract
     * @return float
     */
    function calculate_contract_balance($contract)
    {
        $totalRent = $contract->monthly_rent * $contract->duration_months;
        $totalPaid = $contract->payments()->where('status', 'validated')->sum('amount');
        
        return max(0, $totalRent - $totalPaid);
    }
}

if (!function_exists('is_contract_expiring_soon')) {
    /**
     * Vérifier si un contrat expire bientôt
     *
     * @param \App\Models\Contract $contract
     * @param int|null $days
     * @return bool
     */
    function is_contract_expiring_soon($contract, $days = null)
    {
        $days = $days ?? config('app.contract_expiry_reminder_days', 30);
        $daysUntilExpiry = days_until($contract->end_date);
        
        return $daysUntilExpiry > 0 && $daysUntilExpiry <= $days;
    }
}

if (!function_exists('is_payment_late')) {
    /**
     * Vérifier si un paiement est en retard
     *
     * @param \Carbon\Carbon $dueDate
     * @return bool
     */
    function is_payment_late($dueDate)
    {
        return Carbon::now()->isAfter($dueDate);
    }
}

if (!function_exists('get_user_role_label')) {
    /**
     * Obtenir le label d'un rôle utilisateur
     *
     * @param string $role
     * @return string
     */
    function get_user_role_label($role)
    {
        $labels = [
            'admin' => 'Administrateur',
            'proprietaire' => 'Propriétaire',
            'locataire' => 'Locataire',
            'agent' => 'Agent Immobilier',
        ];
        
        return $labels[$role] ?? $role;
    }
}