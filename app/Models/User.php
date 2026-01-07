<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'country',
        'bio',
        'profile_photo',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Configuration pour le logging des activités
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'phone', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Vérifier si l'utilisateur est actif
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Vérifier si l'utilisateur est un administrateur
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Vérifier si l'utilisateur est un propriétaire
     */
    public function isProprietaire(): bool
    {
        return $this->hasRole('proprietaire');
    }

    /**
     * Vérifier si l'utilisateur est un locataire
     */
    public function isLocataire(): bool
    {
        return $this->hasRole('locataire');
    }

    /**
     * Vérifier si l'utilisateur est un agent immobilier
     */
    public function isAgent(): bool
    {
        return $this->hasRole('agent');
    }

    // ==================== RELATIONS ====================

    /**
     * Biens immobiliers possédés par l'utilisateur (Propriétaire)
     */
    public function ownedProperties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    /**
     * Contrats de location en tant que locataire
     */
    public function rentedContracts()
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }

    /**
     * Contrats gérés en tant que propriétaire
     */
    public function ownedContracts()
    {
        return $this->hasManyThrough(
            Contract::class,
            Property::class,
            'owner_id', // Clé étrangère sur properties
            'property_id', // Clé étrangère sur contracts
            'id', // Clé locale sur users
            'id' // Clé locale sur properties
        );
    }

    /**
     * Paiements effectués par le locataire
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'tenant_id');
    }

    /**
     * Demandes de maintenance créées par le locataire
     */
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'tenant_id');
    }

    /**
     * Demandes de maintenance assignées à un agent/propriétaire
     */
    public function assignedMaintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'assigned_to');
    }

    // ==================== SCOPES ====================

    /**
     * Scope pour récupérer uniquement les utilisateurs actifs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope pour récupérer les propriétaires
     */
    public function scopeProprietaires($query)
    {
        return $query->role('proprietaire');
    }

    /**
     * Scope pour récupérer les locataires
     */
    public function scopeLocataires($query)
    {
        return $query->role('locataire');
    }

    /**
     * Scope pour récupérer les agents
     */
    public function scopeAgents($query)
    {
        return $query->role('agent');
    }

    // ==================== ACCESSEURS ====================

    /**
     * Obtenir l'URL complète de la photo de profil
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        
        // Avatar par défaut basé sur les initiales
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Obtenir le nombre total de biens possédés
     */
    public function getTotalPropertiesAttribute()
    {
        return $this->ownedProperties()->count();
    }

    /**
     * Obtenir le nombre de biens disponibles
     */
    public function getAvailablePropertiesAttribute()
    {
        return $this->ownedProperties()->where('status', 'disponible')->count();
    }

    /**
     * Obtenir le montant total des loyers mensuels
     */
    public function getTotalMonthlyRentAttribute()
    {
        return $this->ownedProperties()
            ->where('status', 'loue')
            ->sum('monthly_rent');
    }

    /**
     * Obtenir les paiements en retard pour un locataire
     */
    public function getOverduePaymentsAttribute()
    {
        return $this->payments()
            ->where('status', 'en_attente')
            ->where('due_date', '<', now())
            ->count();
    }

    /**
     * Obtenir le solde dû par un locataire
     */
    public function getTotalBalanceDueAttribute()
    {
        return $this->payments()
            ->whereIn('status', ['en_attente', 'partiel'])
            ->sum('balance_due');
    }
}